<?php
/**
 * De functies voor dit thema, lees goed alles na en kijk wat je nodig hebt voor je begint te programmeren
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @version     1.0
 */

/* ==========================================================================
   INIT INCLUDES - Zet hier alle includes die je nodig hebt voorafgaand aan je functies
   ========================================================================== */
   
//include_once('test1.php');
//include_once('test2.php');   
   
//include_once('config.php');									// We includen het bestand met alle variabelen voor het thema
include_once('setup.php');									// We includen het bestand met de setup voor de assets van het thema

include_once('includes/acf_fields.php'); 					// We includen standaard ACF velden voor het thema
include_once('includes/helper.php'); 						// We includen de helper functies voor het child thema

include_once('includes/custom-post-type-recipes.php');
include_once('includes/custom-post-type-testimonials.php');

include_once('includes/widget-promo.php');
include_once('includes/widget-random-column.php');
include_once('includes/widget-random-recipe.php');
include_once('includes/widget-recipe-of-the-week.php');
include_once('includes/widget-reference.php');

/* ==========================================================================
   FUNCTIES - Zet hier je generieke functies
   ========================================================================== */
   
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/*
 * Geeft een array van de 5 meest recente producten
 */
function get_recent_product_ids() {
    global $wpdb;
	
	// Haal de ids op van 5 recente producten
	$recent_posts = $wpdb->get_results(
		"
		SELECT ID, meta_value 
		FROM $wpdb->posts 
			INNER JOIN $wpdb->postmeta 
			ON $wpdb->posts.ID = $wpdb->postmeta.post_id 
		WHERE post_type = 'product' 
			AND meta_key = '_visibility' 
			AND meta_value = 'visible' 
		GROUP BY ID 
		ORDER BY post_date 
		LIMIT 5
		", 
		ARRAY_A
	);
	
	$values = '';
	$first = true;
	foreach($recent_posts as $row) {
		
		if($first) {
			
			$values = $row['ID'];
			$first = false;
		}
		else {
			$values .= ', '.$row['ID'];
		}
	}
	
	/* Haal attributen op */
	$recent_attributes = $wpdb->get_results(
		"
		SELECT object_id, taxonomy, name 
		FROM $wpdb->posts 
			INNER JOIN $wpdb->term_relationships 
			ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
			INNER JOIN $wpdb->term_taxonomy 
			ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id 
			INNER JOIN $wpdb->terms 
			ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id 
			INNER JOIN $wpdb->postmeta 
			ON $wpdb->posts.ID = $wpdb->postmeta.post_id
		WHERE post_type = 'product' 
			AND meta_key = '_visibility' 
			AND meta_value = 'visible' 
			AND object_id IN ($values) 
			AND $wpdb->term_taxonomy.taxonomy IN ('pa_kleur', 'pa_jaar', 'product_cat')
		ORDER BY post_date 
		", 
		ARRAY_A
	);
	
	$current_id = 0;
	foreach($recent_posts as $value => $row) {
		$object_id = $row['ID'];
		
		if($object_id != $current_id) {
			$current_id = $object_id;
		}
		
		$recent_merge[$current_id]['ID'] = $row['ID'];
	}
	
	$current_id = 0;
	foreach($recent_attributes as $value => $row) {
		$object_id = $recent_attributes[$value]['object_id'];
		if($recent_merge[$object_id] != null) {
			if($object_id != $current_id) {
				$current_id = $object_id;
			}
			
			$recent_merge[$current_id][$row['taxonomy']] = $row['name'];
		}
	}
	
	return $recent_merge;
}


function the_product_grape_icon() {
	global $product;
	
	$array = woocommerce_get_product_terms($product->id, 'pa_soort', 'names');
	
	// Wit
	if( isset( $array ) && in_array( 'Wit', $array ) ) {
		print '<img class="product-icon-grape" title="' . __( 'Witte wijn', TEXT_DOMAIN ) . '" src="'.get_stylesheet_directory_uri().'/assets/images/ic-grapes-white.png'.'">';
	}
    // Rood
    if( isset( $array ) && in_array( 'Rood', $array ) ) {
        print '<img class="product-icon-grape" title="' . __( 'Rode wijn', TEXT_DOMAIN ) . '" src="'.get_stylesheet_directory_uri().'/assets/images/ic-grapes-red.png'.'">';
    }
    // Rosé
    if( isset( $array ) && in_array( 'Rosé', $array ) ) {
        print '<img class="product-icon-grape" title="' . __( 'Rosé wijn', TEXT_DOMAIN ) . '" src="'.get_stylesheet_directory_uri().'/assets/images/ic-grapes-rose.png'.'">';
    }
}

/**
 * Geeft een array van uitgelichte producten
 */
function get_featured_product_ids() {
    global $wpdb;
	
	$featured = $wpdb->get_results(
		"
		SELECT ID
		FROM $wpdb->posts 
			INNER JOIN $wpdb->postmeta
			ON $wpdb->posts.ID = $wpdb->postmeta.post_id
		WHERE post_type = 'product'
			AND meta_key = '_featured'
			AND meta_value = 'yes'
		", 
		ARRAY_N
	);
	
	if(!$featured[0]) {
		return null;
	}
	
	return $featured[0];
}

/* ==========================================================================
   FRONTEND FUNCTIES - Zet hier je eigen get_ en the_ functies voor de frontend
   ========================================================================== */

/**
 * Een functie voor een excerpt met custom lengte
 */
function get_excerpt_max_length($charlength) {
	
	$excerpt = get_the_excerpt();

    if( strlen( $excerpt ) > 0 )
        $excerpt = get_the_content();

	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$return_excerpt = '';
		
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$return_excerpt = mb_substr( $subex, 0, $excut );
		}
        else {
			$return_excerpt = $subex;
		}

		
		//$read_more = defined( 'CUSTOM_EXCERPT' ) ? CUSTOM_EXCERPT : '[..]';
        $read_more = '[...]';

        if( is_archive() ) {

            global $post;
            $read_more .= ' ' . '<a class="permalink-more" href="' . get_permalink( $post->ID ) . '">meer info</a>';
        }

		return $return_excerpt . $read_more;
	} 
	else {
		return $excerpt;
	}
}


/**
 * Echo de naam van de gebruiker als die ingelogd is
 */
function the_username() {
	
	if( is_user_logged_in() ) {
		
    	$current_user = wp_get_current_user();
		
		echo $current_user->data->display_name;
	}
}

function search_excerpt_length( $length ) {

	//if( is_search() && !is_woocommerce() ) {
		return 100;
	//}

	echo 'bla';

	return $length;
}
add_filter( 'excerpt_length', 'search_excerpt_length', 9999 );

/* ==========================================================================
   ACTION HOOKS - Zet hier functies die je koppelt aan WordPress hooks
   ========================================================================== */

/**
 * Verwijder actions uit het basis thema
 */
function after_setup_theme_changes() {
	if(!is_admin()) {
		remove_action( 'login_head', 'custom_login_logo' );
	}
}
add_action( 'after_setup_theme', 'after_setup_theme_changes' );

/**
 * Voeg hier javascript variabelen toe. Deze worden geprint in de head en kunnen gebruikt worden in js bestanden
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
if( !function_exists( 'add_js_variables_in_head' ) ) {
	
	function add_js_variables_in_head_child() {    
	    echo "<script type='text/javascript'>";
		
		    echo "var templateUrl = '" . get_stylesheet_directory_uri() . "';";
			
			if( function_exists( 'get_field' )) {
				if( strlen( get_field( 'maps_latitude', 'options' ) ) > 0 ) {
			    	echo "var mapsLatitude = '". get_field( 'maps_latitude', 'options' ) ."';";
				}
	
				if( strlen( get_field( 'maps_longitude', 'options' ) ) > 0 ) {
			    	echo "var mapsLongitude = '". get_field( 'maps_longitude', 'options' ) ."';";
				}
				
				if( strlen( get_field( 'maps_tooltip_inhoud', 'options' ) ) > 0 ) {
			    	echo "var mapsTooltip = ". json_encode( get_field( 'maps_tooltip_inhoud', 'options' ) ) .";";
				}
				
				if( strlen( get_field( 'maps_marker_titel', 'options' ) ) > 0 ) {
			    	echo "var mapsMarkertitel = ". json_encode( get_field( 'maps_marker_titel', 'options' ) ) .";";
				}
			}
	            
	    echo "</script>";
	}
	add_action('wp_head', 'add_js_variables_in_head_child', 90, 0);
}
   
   

/* ==========================================================================
   FILTER HOOKS - Zet hier functies die je koppelt aan WordPress filters
   ========================================================================== */


/**
 * We filteren de content weg op de zoekpagina van producten
 * TODO Defect
 */
function filter_product_search_content( $content ) {

    global $wp_query;

    if( is_search() && $wp_query->query_vars['post_type'] == 'product' ) {
        get_search_form();

        return;
    }

    return $content;
}
//add_filter( 'the_content', 'filter_product_search_content' );


/**
 * We wijzigen het aantal gerelateerde producten
 */
function woo_related_products_limit() {
	global $product;
	
	$related = $product->get_related( 4 );
	
	$args = array(
		'post_type'        		=> 'product',
		'no_found_rows'    		=> 1,
		'posts_per_page'   		=> 4,
		'ignore_sticky_posts' 	=> 1,
		'orderby'             	=> 'rand',
		'post__in'            	=> $related,
		'post__not_in'        	=> array($product->id)
	);
	return $args;
}
add_filter( 'woocommerce_related_products_args', 'woo_related_products_limit' );


function woocommerce_additional_body_classes($classes) {
	
	global $post;
	
	if($post) {
		if($post->ID == get_option( 'woocommerce_checkout_page_id' )) {
			//array_push($classes, 'woocommerce-checkout' );
		}
	}
	
	return $classes;
}
add_filter('body_class','woocommerce_additional_body_classes');



/* ==========================================================================
   AJAX - Zet hier de functies die je aanroept met Ajax posts
   ========================================================================== */



/* ==========================================================================
   MENUS - Registreer hier je menus
   ========================================================================== */

/**
 * Registreer de menu's die gebruikt worden in de site en weergegeven zullen worden in de backend
 * 
 * Dit is vaste menu's, er kan er slechts 1 van bestaand binnen WordPres
 */
function register_my_menus() {
  	register_nav_menu(
  		'primary-left', 										// De id voor het menu
  		__( 'Hoofdmenu bovenin links', 'Sebwite thema' )		// De titel voor het menu
	);
  	register_nav_menu(
  		'primary-right', 										// De id voor het menu
  		__( 'Hoofdmenu bovenin rechts', 'Sebwite thema' )		// De titel voor het menu
	);
  	register_nav_menu(
  		'primary-left-loggedin', 											// De id voor het menu
  		__( 'Hoofdmenu bovenin links indien ingelogd', 'Sebwite thema' )	// De titel voor het menu
	);
  	register_nav_menu(
  		'primary-right-loggedin', 											// De id voor het menu
  		__( 'Hoofdmenu bovenin rechts indien ingelogd', 'Sebwite thema' )	// De titel voor het menu
	);
  	register_nav_menu(
  		'footer', 												// De id voor het menu
  		__( 'Links in de footer', 'Sebwite thema' )				// De titel voor het menu
	);
}
add_action( 'init', 'register_my_menus' );


/* ==========================================================================
   SIDEBARS - Registreer hier je sidebars
   ========================================================================== */

/**
 * Registreer een sidebar
 */
function register_my_sidebars() {
	
    // Registreer een zijbalk
    /*
    register_sidebar(
        array(
	        'id' => 'sidebar-left',															// De id van de sidebar in de HTML
	        'name' => __('Linker Zijbalk'),													// De titel in de backend voor WordPress
	        'description' => __('Dit is de linker zijbalk'),								// De omschrijving in de backend voor WordPress
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',					// Voor widgets - wordt geprepend voor de widget
	        'after_widget' => '</div></section>',											// Voor widgets - wordt append achter de widget
	        'before_title' => '<header class="widget-header"><h3 class="widget-title">',	// Voor widgets - wordt geprepend voor de widget titel
	        'after_title' => '</h3></header><div class="widget-body">'						// Voor widgets - wordt append achter de widget titel
        )
    );
    */
	
    // Registreer een zijbalk
    register_sidebar(
        array(
	        'id' => 'sidebar-right',														// De id van de sidebar in de HTML
	        'name' => __('Rechter Zijbalk'),												// De titel in de backend voor WordPress
	        'description' => __('Dit is de rechter zijbalk'),								// De omschrijving in de backend voor WordPress
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',					// Voor widgets - wordt geprepend voor de widget
	        'after_widget' => '</div></section>',											// Voor widgets - wordt append achter de widget
	        'before_title' => '<header class="widget-header"><h3 class="widget-title">',	// Voor widgets - wordt geprepend voor de widget titel
	        'after_title' => '</h3></header><div class="widget-body">'						// Voor widgets - wordt append achter de widget titel
        )
    );
}
add_action( 'widgets_init', 'register_my_sidebars' );

/* ==========================================================================
   PERMALINK MODIFICATIES - 
   Zet hier de functies waarmee je permalink aanpassingen doet
   ========================================================================== */



/* ==========================================================================
   WIDGETS - Plaats hier de includes van je Widget bestanden
   ========================================================================== */

//include_once 'widget-example.php';

/* ==========================================================================
   CUSTOM POST TYPES - Plaats hier de includes van je CPT bestanden
   ========================================================================== */

//include_once 'custom-post-type-example.php';

/* ==========================================================================
   PLUGIN MODIFICATIES - Aanpassingen die je maakt aan plugins
   ========================================================================== */


/**
 * We maken onze optie pagina's aan voor ACF
 * We verbergen ook de Sebwite thema opties pagina voor non-SUPERADMIN
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
if( !function_exists( 'my_acf_options_page_settings' ) ) {
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	if( is_plugin_active('advanced-custom-fields/acf.php') && is_plugin_active('acf-options-page/acf-options-page.php') ) {
		
		// Voeg de Globaal pagina toe
		acf_add_options_sub_page(array(
		    'title' => 'Globaal',
		    'capability' => 'manage_options'
		));
		
		// Voeg the Thema pagina toe voor SUPERADMIN
		if( is_current_user_superadmin() ) {
			acf_add_options_sub_page(array(
			    'title' => 'Sebwite Thema',
			    'capability' => 'manage_options'
			));
		}
	}
}

/* ==========================================================================
   WOOCOMMERCE - Zet hier je woocommerce hook modificaties
   ========================================================================== */

/**
 * We vervangen de standaard placeholder door onze eigen
 */
function custom_placeholder() {
   
	function custom_woocommerce_placeholder_img_src( $src ) {
		return get_stylesheet_directory_uri() . '/assets/images/placeholder.png';
	}
	add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
}
add_action( 'init', 'custom_placeholder' );


/**
 * We echo-en een plaatsvervanger als er geen prijs is ingesteld
 */
function sold_price($price) {
	if($price  == ''){
	    return '<span class="no-amount">' . __( 'Tijdelijk uitverkocht', 'Basis thema' ) . '</a>';
	}
	else {
		return $price;
	}
}
add_filter( 'woocommerce_get_price_html', 'sold_price' );

 
/**
 * We openen de anchor voor de thumbnail in het archief
 */
function anchor_before_loop_product_thumbnail() {
	echo '<a class="wp-post-image-anchor" href="' . get_permalink() . '">';
}


/**
 * We sluiten de anchor voor de thumbnail in het archief
 */
function anchor_after_loop_product_thumbnail() {
	echo '</a>';
}


/**
 * We echo-en een excerpt met aangepaste lengte
 */
function the_archive_excerpt() {
	echo '<p>' . get_excerpt_max_length( 350 ) . '</p>';
}



/**
 * We filteren de excerpt op de zoekpagina
 */
function the_search_excerpt() {
	echo '<p>' . get_excerpt_max_length( 200 ) . '</p>';
}


/**
 * We echo-en een 'meer info'-knop
 */
function the_archive_more_info() {
	echo '<a class="button more-info" href="' . get_permalink() . '">' . __( 'Meer info', 'Basis thema' ) . '</a>';
}


/**
 * We echo-en een 'meer info'-knop
 */
function the_archive_price_continue() {
	
	echo '<div class="info-container">';
	woocommerce_template_loop_price();
	echo '<a class="big-button more-info" href="' . get_permalink() . '">' . __( 'Meer info', 'Basis thema' ) . '</a>';
	echo '</div>';
}


/**
 * We echo-en een div met de clearfix class
 */
function the_clearfix() {
	echo '<div class="clearfix"></div>';
}

?>
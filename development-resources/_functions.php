<?php
/**
 * Code snippets voor in je functions bestanden. 
 * 
 * INCLUDE & PAS DIT BESTAND NIET AAN - KOPIEER/WIJZIG FUNCTIES DIE JE NODIG HEBT
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @version     1.0
 */

/* ==========================================================================
   SOCIAL MEDIA - Snippets relateerd aan Social Media
   ========================================================================== */

/**
 * We voegen de facebook code toe met onze eigen hook onder de wp_head hook
 * 
 * @global 	FACEBOOK_APP_ID - Moet het facebook app Id bevatten
 * @author 	Brian de Geus
 * @since 	1.0
 */
function add_facebook_in_head() {
	echo '
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1&appId='.FACEBOOK_APP_ID.'";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, "script", "facebook-jssdk"));
		</script>';
}
add_action('wp_head', 'add_facebook_in_head', 100, 0);


/* ==========================================================================
   HEADER - Snippets voor in je header
   ========================================================================== */

/** 
 * Voeg een favicon element toe aan je header
 * 
 * @global 	FAVICON_PATH - Moet het pad naar je favicon vanaf je template dir bevatten
 * @author 	Brian de Geus
 * @since 	1.0
 */
function add_favicon_in_head() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('template_directory').FAVICON_PATH.'" />';
}
add_action('wp_head', 'add_favicon_in_head', 5, 0);


/**
 * Voeg hier javascript variabelen toe. Deze worden geprint in de head en kunnen gebruikt worden in js bestanden
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
function add_js_variables_in_head() {    
    echo "<script type='text/javascript'>".
            "var templateUrl = '". get_bloginfo("template_url") ."';".
            "var ajaxUrl = '". admin_url('admin-ajax.php') ."';".
        "</script>";
}
add_action('wp_head', 'add_js_variables_in_head');


/* ==========================================================================
   FOOTER - Snippets voor in je footer
   ========================================================================== */


/**
 * Voeg Google Analytics code toe aan de footer met een hoge prioriteit
 * Google wil hem nog binnen de body maar als eerste in de footer is ook prima
 * 
 * @global 	ANALYTICS_CODE - Moet de Analytics code van de het Analytics account profiel bevatten
 * @global 	ANALYTICS_SITEURL - Moet de simpele site URL zoals in Analytics ingesteld is bevatten
 * @author 	Brian de Geus
 * @since 	1.0
 */
function add_google_analytics_in_footer() {
	echo "
		<script type='text/javascript'>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', '".ANALYTICS_CODE."', '".ANALYTICS_SITEURL."');
		  ga('send', 'pageview');
        </script>";
}
add_action('wp_footer', 'add_google_analytics_in_footer', 1, 0);


/* ==========================================================================
   USER - Snippets met betrekking tot user
   ========================================================================== */


/**
 * Voorkom de verwijdering van enkele pagina's door non-SUPERADMIN_USERNAME users
 * 
 * @uses WPML - Deze snippet gaat ervan uit dat je WPML gebruikt
 * @global 	SUPERADMIN_USERNAME - Moet de Analytics code van de het Analytics account profiel bevatten
 * @global 	RESTRICTED_PAGE_IDS - Moet een array bevatten met page_id integers serialized
 * @author 	Brian de Geus
 * @since 	1.0
 */
function restrict_post_deletion($post_ID){
    $current_user = wp_get_current_user();
	
	// Kijk of de gebruiken niet sebadmin is en of het een niet-te-verwijderen pagina id is
	if(SUPERADMIN_USERNAME != $current_user->user_login) {
				
		$restricted_ids = unserialize(RESTRICTED_PAGE_IDS);
		
		foreach($restricted_ids as $restricted_id) {
			
			if(icl_object_id($restricted_id, 'page', false) == $post_ID) {
		        _e("You are not authorized to delete this page. Please contact Sebwite if you are sure you want to delete this page.", 'Sebwite thema');
		        exit;
			}
		}
	}
}
add_action('wp_trash_post', 'restrict_post_deletion', 10, 1);
add_action('before_delete_post', 'restrict_post_deletion', 10, 1);


/**
 * Verwijderd menu items voor non-SUPERADMIN_USERNAME users
 * 
 * @global 	SUPERADMIN_USERNAME - Moet de Analytics code van de het Analytics account profiel bevatten
 * @author 	Brian de Geus
 * @since 	1.0
 */
function remove_admin_menus() {
    global $menu;
    
    $current_user = wp_get_current_user();
	
	// Kijk of de gebruiken niet sebadmin
	if(SUPERADMIN_USERNAME != $current_user->user_login) {
		
	    // Admin functies verbergen
	    $restricted = array(__('Posts'), __('Comments'));
	    end ($menu);
	    while (prev($menu)){
	        $value = explode(' ',$menu[key($menu)][0]);
	        
	        if(in_array($value[0] != NULL ? $value[0] : "" , $restricted)) {
	            unset($menu[key($menu)]);
	        }
	    }
	}
}
add_action('admin_menu', 'remove_admin_menus');


/* ==========================================================================
   POST - Post gerelateerde snippets
   ========================================================================== */

/**
 * Verander de excerpt lengte
 * 
 * @global 	EXCERPT_LENGTH - Moet de lengte van de except bevaten (in woorden)
 * @author 	Brian de Geus
 * @since 	1.0
 */
function custom_excerpt_length($old_length) {
    return $new_length = EXCERPT_LENGTH;
}
add_filter('excerpt_length', 'custom_excerpt_length', 10, 1);


/* ==========================================================================
   BANKEND - Backend gerelateerde snippets
   ========================================================================== */


/** 
 * BEGIN - Backend WYSIWYG-editor styling
 * 
 * Voeg een format/stijl toe aan de format/stijl dropdown in de MCE editor
 * en voeg css toe aan deze gegeven stijl in de backend editor
 * 
 * @uses 	editor-style.css - Deze css moet zich bevinden in de theme root
 * @author 	Brian de Geus
 * @since 	1.0
 * -------------------------------------------------------------------------- */
   
/**
 * Voeg de styling toe aan de visuele backend editor
 */  
function tuts_mcekit_editor_style($url) {

    if ( !empty($url) )
        $url .= ',';

    // Voeg de editor-styles.css toe aan de backend editors vanuit de template directory
    $url .= get_template_directory_uri().'/editor-styles.css';

    return $url;
}
add_filter('mce_css', 'tuts_mcekit_editor_style');

/**
 * Voeg de 'Styles' dropdown toe
 */  
function tuts_mcekit_editor_buttons($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'tuts_mcekit_editor_buttons');

/**
 * Voeg opties toe aan de 'Styles' dropdown gekoppeld aan classes
 */  
function tuts_mcekit_editor_settings($settings) {
    if (!empty($settings['theme_advanced_styles']))
        $settings['theme_advanced_styles'] .= ';';    
    else
        $settings['theme_advanced_styles'] = '';

	// De array met de dropdown optie en HTML class
    $classes = array(
        __('Highlight', 'textdomain') => 'highlight'
    );

    $class_settings = '';
    foreach ( $classes as $name => $value )
        $class_settings .= "{$name}={$value};";

    $settings['theme_advanced_styles'] .= trim($class_settings, '; ');
    return $settings;
}
add_filter('tiny_mce_before_init', 'tuts_mcekit_editor_settings');

/* -------------------------------------------------------------------------- 
 * EINDE - Backend WYSIWYG-editor styling
 */


/* ==========================================================================
   AJAX - Backend gerelateerde snippets
   ========================================================================== */

/**
 * Een voorbeeld ajax call
 * 
 * @uses 	_scripts.js - Een javascript functie moet deze functie met een Ajax post aanroepen
 * @author 	Brian de Geus
 * @since 	1.0
 */
function example_callback() {	
	
	$var1 = $_POST['var1'];
	
	echo '<h1>' . $var1 . '</h1>';

	die(); // this is required to return a proper result
}
add_action('wp_ajax_example_callback', 'example_callback');			// Deze call werkt in de frontend voor inlogde users
add_action('wp_ajax_nopriv_example_callback', 'example_callback');	// De tweede call is voor niet-ingelogde users


/* ==========================================================================
   SIDEBARS - Sidebar gerelateerde snippets
   ========================================================================== */

/**
 * Registreer de sidebars die gebruikt worden in de site en weergegeven zullen worden in de backend
 * 
 * @uses 	_scripts.js - Een javascript functie moet deze functie met een Ajax post aanroepen
 * @author 	Brian de Geus
 * @since 	1.0
 */
function register_sidebars() {
	
    // Registreer de voorbeeld zijbalk die de headlines weergeeft
    register_sidebar(
        array(
            'id' => 'sidebar-subpages',
            'name' => __('Subpages Sidebar'),
            'description' => __('This sidebar displays all headlines/topics. Widgets you add will be placed under the headlines/topics.'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<header class="widget-header"><h3 class="widget-title">',
            'after_title' => '</h3></header>'
        )
    );
    
    // Registreer de voorbeeld zijbalk voor de homepage
    register_sidebar(
        array(
            'id' => 'sidebar-home',
            'name' => __('Home Sidebar'),
            'description' => __('This sidebar displays widget on the homepage.'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<header class="widget-header"><h3 class="widget-title">',
            'after_title' => '</h3></header>'
        )
    );
}
add_action( 'widgets_init', 'register_sidebars' );


/* ==========================================================================
   PERMALINK - Permalink gerelateerde snippets
   ========================================================================== */


/** 
 * BEGIN - Aanpassingen aan de permalink structuur voor een CPT
 * 
 * De CPT heeft rlt_rule en heb taxonomie rlt_rule_year
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 * -------------------------------------------------------------------------- */
 
/**
 * Als onze rewrite rule nog niet bestaat flushen we de rules en voegen we hem toe
 * LET OP: Bij ontwikkelen moet je nog steeds bij aanpassingen constant de permalinks updaten in WordPress instellingen
 */
function rlt_rule_flush_rules() {
	$rules = get_option( 'rewrite_rules' );

	if(!isset( $rules['^rule/([^/]*)/([^/]*)/([^/]*)'])) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}
}
add_action('wp_loaded', 'rlt_rule_flush_rules');


/**
 * Deze rewrite wordt toegevoegd aan de htaccess
 */
function rlt_rule_rewrite_rules( $rules ) {
	$newrules = array();
	$newrules['^rule/([^/]*)/([^/]*)/([^/]*)'] = 'index.php?post_type=rlt_rule&p=$matches[1]&rlt_rule_year=$matches[2]&rule=$matches[3]&name=$matches[3]';
	return $newrules + $rules;
}
add_filter('rewrite_rules_array','rlt_rule_rewrite_rules');


/**
 * We geven nieuwe variabelen door aan WordPress als query variabelen
 */
function rlt_rule_query_vars( $vars ) {
    array_push($vars, 'rule_slug', 'rule_id', 'rule_name');
    return $vars;
}
add_filter('query_vars', 'rlt_rule_query_vars');


/**
 * We zetten de standaard permalink structuur op voor rules
 * LET OP: rewrite moet op false in de CPT registratie
 */
function rlt_rule_add_permalink_rewrites(){
	global $wp_rewrite;
	
	$structure = '/rule/%rule_id%/%rule_year%/%rule_name%';
	
	$wp_rewrite->add_rewrite_tag('%rule_id%', '([^/]+)', 'page_id=');  
	$wp_rewrite->add_rewrite_tag('%rule_year%', '([^/]+)', 'rlt_rule_year='); 
	$wp_rewrite->add_rewrite_tag('%rule_name%', '([^/]+)', 'name=');  
	$wp_rewrite->add_rewrite_tag('%rule_name%', '([^/]+)', 'page=');  
	
	$wp_rewrite->add_permastruct('rlt_rule', $structure, false);
}
add_action('init', 'rlt_rule_add_permalink_rewrites');


/**
 * We vullen hier de permalink in met variabelen
 * 
 * @see wp-includes/link-template.php
 */
function rlt_rule_permalink($permalink, $post_id, $leavename) {
	
    $post = get_post($post_id);
	
	if($post->post_type == 'rlt_rule') {
		
		if ( '' != $permalink && !in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
		
		    $rewritecode = array(
		        '%rule_id%',
		        '%rule_year%',
		        '%rule_name%'
		    );
			
			$rule_id = '';
			if(strpos($permalink, '%rule_id%') !== false) {
				$rule_id = $post->ID;
			}
			
			$rule_year = '';
			if(strpos($permalink, '%rule_year%') !== false) {
				$terms = get_the_terms($post->ID, 'rlt_rule_year');
			    $rule_year = $terms[key($terms)]->slug;
			}
			
			$rule_name = '';
			if(strpos($permalink, '%rule_name%') !== false) {
				$rule_name = $post->post_name;
			}
			
			$rewritereplace = array(
	            $rule_id,
	            $rule_year,
	            $rule_name
	        );
					
			$permalink = str_replace($rewritecode, $rewritereplace, $permalink);
		}
	}
	
    return $permalink;
}
add_filter('post_type_link', 'rlt_rule_permalink', 10, 3);   

/* -------------------------------------------------------------------------- 
 * EINDE - Aanpassingen aan de permalink structuur voor een CPT
 */


/* ==========================================================================
   ADMIN FUNCTIES - Backend gerelateerde functies
   ========================================================================== */


/**
 * Verwijder het label 'Private: ' van private posts
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
function remove_private_label( $title ) { 
	global $post;
	
	if ( isset($post->post_status) && 'private' == $post->post_status ){
		if ( substr($title,0,9) == 'Private: ' ){
			$title = substr($title,9);
		}
	}
	return $title;
}
add_action( 'the_title','remove_private_label' );


/**
 * Verwijder metaboxes uit de backend bewerkpagina's
 * Overweeg een eventuele conditional bij bepaalde gebruikers/gebruikersrollen
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 * @link 	http://codex.wordpress.org/Function_Reference/remove_meta_box
 */
function my_remove_meta_boxes() {

	remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' ); 	// Tags metabox.
	remove_meta_box( 'postcustom', 'post', 'normal' ); 			// Custom fields metabox.
	remove_meta_box( 'postexcerpt', 'post', 'normal' ); 		// Excerpt metabox.
	remove_meta_box( 'authordiv', 'post', 'normal' ); 			// Author metabox.
	remove_meta_box( 'revisionsdiv', 'post', 'normal' ); 		// Revisions metabox.
	remove_meta_box( 'commentstatusdiv', 'post', 'normal' ); 	// Comments status metabox (discussion).
	remove_meta_box( 'commentsdiv', 'post', 'normal' ); 		// Comments metabox.
	remove_meta_box( 'trackbacksdiv', 'post', 'normal' ); 		// Trackbacks metabox.
	remove_meta_box( 'slugdiv', 'post', 'normal' );				// Slug metabox.
	
	remove_meta_box( 'postimagediv', 'post', 'normal' );		// Featured image metabox.
	remove_meta_box( 'formatdiv', 'post', 'normal' );			// Formats metabox.
	remove_meta_box( 'categorydiv', 'post', 'normal' );			// Categories metabox.
	remove_meta_box( 'pageparentdiv', 'post', 'normal' );		// Attributes metabox.
}
add_action( 'admin_menu', 'my_remove_meta_boxes' );


/**
 * Verwijder de adminbar in de backend
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
function disable_adminbar() {
    remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 );
	
    function remove_admin_bar_style_backend() {
        echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
    }
    add_filter('admin_head','remove_admin_bar_style_backend');
}  
add_action( 'init', 'disable_adminbar' );


/**
 * Verberg menu pagina's
 * Overweeg een conditional bij bepaalde gebruikers/gebruikersrollen of
 * voeg de add_action toe in een functie die een gros add_action's uitvoert met een conditional
 * 
 * Tip: Je kan ook menu's arrangeren
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
function my_remove_menu_pages() {
	
	// Verberg standaard menu items (dit zijn enkele voorbeelden)
	remove_menu_page('link-manager.php');
	remove_menu_page('tools.php');
	remove_menu_page('options-general.php');	
	remove_menu_page('plugins.php');	
	remove_menu_page('edit-comments.php');
	
	// Verberg non-standaard menu items, print de global menu op je item te vinden (dit zijn enkele voorbeelden)
    global $menu;
	
    unset($menu[81]);		// ACF
    unset($menu[100]);  	// WPML
	
	
	// Verberg standaard submenu items (dit zijn enkele voorbeelden)
	$page = remove_submenu_page( 'edit.php', 'edit-tags.php' );
    $page = remove_submenu_page( 'edit.php', 'edit-tags.php' );
	
	$page = remove_submenu_page( 'themes.php', 'themes.php' );
	$page = remove_submenu_page( 'themes.php', 'widgets.php' );
	$page = remove_submenu_page( 'themes.php', 'nav-menus.php' );
	$page = remove_submenu_page( 'themes.php', 'theme-editor.php' );
	$page = remove_submenu_page( 'themes.php', 'customize.php' );
	
	$page = remove_submenu_page( 'users.php', 'users.php' );
	$page = remove_submenu_page( 'users.php', 'user-new.php' );
	$page = remove_submenu_page( 'index.php', 'update-core.php' ); 
		
	// Verberg non-standaard submenu items, print de global submenu op je item te vinden (dit zijn enkele voorbeelden)
    global $submenu;
    
    unset($submenu['sitepress-multilingual-cms/menu/languages.php'][0]);
    unset($submenu['sitepress-multilingual-cms/menu/languages.php'][1]);
    unset($submenu['sitepress-multilingual-cms/menu/languages.php'][2]);
    unset($submenu['sitepress-multilingual-cms/menu/languages.php'][3]);
}
add_action( 'admin_menu', 'my_remove_menu_pages' );


/**
 * Verwijder dashboard widgets
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
function remove_dashboard_widgets() {
	global $wp_meta_boxes;
  	
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); 
	unset($wp_meta_boxes['dashboard']['side']['core']['categorydiv']); 
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );


/**
 * Verwijder contactmethodes, deze gebruiken we namelijk in Nederland bijna niet
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
function remove_contactmethods( $contactmethods ) {
	unset( $contactmethods['yim'] ); // Remove Yahoo IM
	unset( $contactmethods['aim'] ); // Remove AIM
	unset( $contactmethods['jabber'] ); // Remove Jabber
	
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'remove_contactmethods' );


/**
 * Pas gebruikersrollen aan en voeg permissies toe
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
function add_theme_caps() {

	// Geef de rol 'editor' de mogelijkheid om menu's te beheren
	$role = get_role( 'editor' );
	$role->add_cap( 'edit_theme_options' );
	
	// Geef de rol 'author' de mogelijkheid om een andermans post te editen
    $role = get_role( 'author' );
    $role->add_cap( 'edit_others_posts' ); 
}
add_action( 'admin_init', 'add_theme_caps');


/* ==========================================================================
   SHORTCODES - Voeg hier shortcodes toe
   ========================================================================== */


/**
 * Shortcode om een complete post te tonen in een andere post of page
 * 
 * [include-post post_id="%post_id%"]
 * 
 * @author 	Brian de Geus
 * @since 	1.0
 */
function include_full_post_shortcode($atts) {
	if ((isset($atts['post_id'])) && (is_numeric($atts['post_id']))) {
		
		$getpost = get_post($atts['post_id']);
		$getpostcontent = apply_filters('the_content', $getpost->post_content);
	
		return $getpostcontent;		
	}
	else {
		return false;
	}
}
add_shortcode('include-post', 'include_full_post_shortcode');


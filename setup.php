<?php
/**
 * De settings voor dit thema
 * 
 * LET OP! Lees goed alles na en kijk wat je nodig hebt voor je begint te programmeren. Als je iets niet nodig hebt, verwijder dan niet de contant maar zet hem op false
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme-Child
 * @version     1.0
 */
 
add_theme_support( 'woocommerce' );
 
/* ==========================================================================
   DEFINITIONS
   ========================================================================== */

define( 'THEME_VERSION', 0.1 );											// De themaversie, verander voor een gedwongen update van CSS/JS bij updates
define( 'TEXT_DOMAIN', 'bordeaux' );									// Het textdomain voor WPML etc
define( 'SUPERADMIN_USERNAME', 'geusadmin' );							// Schrijf de login van de superadmin

define( 'ENABLE_WOOCOMMERCE', false );									// Zet op true voor een Woocommerce project

define( 'ENABLE_PRETTYPHOTO', true );									// Zet op true voor prettyPhoto
define( 'ENABLE_MODERNIZR', true );										// Zet op true voor modernizr

define( 'FAVICON_PATH', '/favicon.ico' );								// Schrijf hier het favicon pad vanuit de theme root

/* Google Analytics
 * ------------------------ */
define( 'ANALYTICS_CODE', '' );											// Plak de analytics code
define( 'ANALYTICS_SITEURL', '' );										// Plak de analytics site_url eg. sebwite.nl

// Rollen waarbij Analytics geinclude wordt
define( 'INCLUDE_GA_ADMINISTRATOR', false );							// Track analytics indien true
define( 'INCLUDE_GA_EDITOR', false );									// Track analytics indien true
define( 'INCLUDE_GA_AUTHOR', false );									// Track analytics indien true
define( 'INCLUDE_GA_CONTRIBUTOR', false );								// Track analytics indien true
define( 'INCLUDE_GA_SUBSCRIBER', true );								// Track analytics indien true
define( 'INCLUDE_GA_GUEST', true );										// Track analytics indien true

// Facebook
define( 'FACEBOOK_APP_ID', '' );										// Indien je facebook APIs gebruikt, plak hier de app ID

// Onverwijderbare pagina ids (pas de 0 aan)
define( 'RESTRICTED_PAGE_ID_1', 0 );
define( 'RESTRICTED_PAGE_ID_2', 0 );

define( 'RESTRICTED_PAGE_IDS', serialize( array( RESTRICTED_PAGE_ID_1, RESTRICTED_PAGE_ID_2 ) ) );		// Deze array wordt gekoppeld aan een functie

// Enkele opties
define( 'REMOVE_UNNESSECARY_HEADER_FUNCTIONS', true );					// Zet standaard WP header info uit
define( 'CUSTOM_EXCERPT', '...' );										// De excerpt 'more..' string

// DEFINE de columns die ingeladen moeten worden
// BIJV: tags,author, date, comments,title
define( 'POSTS_HIDE_COLUMNS', 'comments' );
define( 'PAGES_HIDE_COLUMNS', 'comments' );

define( 'OTHER_ADMINS_CAN_VIEW_SEO', TRUE );							// Zet aan als andere beheerders het SEO-tabje mogen zien

/* Tiny MCE editor
 * ------------------------ */
define( 'MCE_H1', false );												// Schakel de koptekst 1 aan
define( 'MCE_H2', true );												// Schakel de koptekst 2 aan
define( 'MCE_H3', true );												// Schakel de koptekst 3 aan
define( 'MCE_H4', false );												// Schakel de koptekst 4 aan
define( 'MCE_CUSTOM_COLORS', 'FF00FF,FFFF00,000000' );					// Voeg custom kleuren toe voor dit thema in de editor

// Beheer hier zichtbare menuitems voor non-superadmin gebruikers (dus ook normale admins)
define( 'MENU_SHOW_DASHBOARD', true);
define( 'MENU_SHOW_POSTS', true);
define( 'MENU_SHOW_MEDIA', true);
define( 'MENU_SHOW_PAGES', true);
define( 'MENU_SHOW_COMMENTS', false);

define( 'MENU_SHOW_THEMES', false);
define( 'MENU_SHOW_PLUGINS', false);
define( 'MENU_SHOW_USERS', true);
define( 'MENU_SHOW_TOOLS', false);
define( 'MENU_SHOW_OPTIONS_GENERAL', false);

define( 'MENU_SHOW_PLUGIN_CONTACT_FORM_7', false);
define( 'MENU_SHOW_PLUGIN_YOAST_SEO', false);

// Zet de volgende variabelen op false om 'Extra Velden' weer te geven voor alle admin gebruikers

global $current_user;
get_currentuserinfo();

// We voeren alleen restricties door als de admin niet de superadmin (sebadmin) is
if( defined( 'SUPERADMIN_USERNAME' ) && ( $current_user->user_login != SUPERADMIN_USERNAME ) ) {
	define( 'ACF_LITE' , true );
}

/* ==========================================================================
   POST IMAGES
   ========================================================================== */

/**
 * 	Wijzig/voeg afbeeldingen formaten toe
 *	
 *	---	Als je een afbeelding formaat specifiek voor een CPT wilt toevoegen, begin dan met de naam van de CPT.
 *  bijv. CPT dienst: add_image_size( 'dienst_small', 200, 320, false );
 *
 */ 
function basetheme_after_setup_theme() {  
	//add_theme_support( 'post-thumbnails' );
	//add_image_size( 'small', 200, 320, false );
	//add_image_size( 'largethumb', 200, 200, false );
}
add_action( 'after_setup_theme', 'basetheme_after_setup_theme' ); 

?>

<?php
/**
 * De setup van de assets voor het thema
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme-Child
 * @version     1.0
 */ 

/* Enqueue CSS & JS scripts
   -------------------------------------------------------------------------- */

   
/**
 * Deze functie registreerd scripts en styling voor de frontend
 */
if( !is_admin() ) {
	
	function register_scripts() {
		
		/* Scripts
	   	-------------------------------------------------------------------------- */
		if( defined( 'ENABLE_MODERNIZR' ) && ENABLE_MODERNIZR ) {
		    wp_enqueue_script(
		    	'modernizr', 
		    	get_stylesheet_directory_uri().'/assets/js/vendor/jquery.modernizr.min.js',
		    	array('jquery'),
				THEME_VERSION,
				false
			);
		}
		if( defined( 'ENABLE_PRETTYPHOTO' ) && ENABLE_PRETTYPHOTO ) {
		    wp_enqueue_script(
		    	'prettyphoto', 
		    	get_stylesheet_directory_uri().'/assets/js/vendor/jquery.prettyPhoto.min.js',
		    	array('jquery'),
				THEME_VERSION,
				true
			);
		}
		
		if( function_exists( 'get_field' ) ) {
			
			if(strlen( get_field( 'maps_api_key', 'options' ) ) > 0 ) {
			
			    wp_enqueue_script(
			    	'gMaps', 
			    	'http://maps.googleapis.com/maps/api/js?key=' . get_field( 'maps_api_key', 'options' ) . '&sensor=false',
			    	array('jquery'),
					THEME_VERSION,
					true
				);
			}
		}
		
	    wp_enqueue_script(
	    	'plugins', 
	    	get_stylesheet_directory_uri().'/assets/js/plugins.js',
	    	array( 'jquery' ),
			THEME_VERSION,
			true
		);
	    wp_enqueue_script(
	    	'main', 
	    	get_stylesheet_directory_uri().'/assets/js/main.js',
	    	array( 'plugins' ),
			THEME_VERSION,
			true
		);
		
		/* Styles
	   	-------------------------------------------------------------------------- */
	   	$styles = array();
	   	
		if( defined( 'ENABLE_MODERNIZR' ) && ENABLE_MODERNIZR ) {
			// Modernizr styling
			wp_register_style( 
				'normalize', 
				get_stylesheet_directory_uri() . '/assets/css/vendor/normalize.min.css', 
				array(), 
				THEME_VERSION, 
				'all'
			);
			array_push( $styles, 'normalize' );
		}
	
		if( defined( 'ENABLE_PRETTYPHOTO' ) && ENABLE_PRETTYPHOTO ) {
			// PrettyPhoto styling
			wp_register_style( 
				'prettyphoto', 
				get_stylesheet_directory_uri() . '/assets/css/vendor/prettyPhoto.min.css', 
				array(), 
				THEME_VERSION, 
				'all'
			);
			
			array_push( $styles, 'prettyphoto' );
		}
		
		// WordPress style - Wordt alleen voor de WordPress backend gebruikt
		// TODO Hoeft waarschijnlijk niet include worden
		wp_register_style( 
			'style', 
			get_stylesheet_directory_uri() . '/style.css', 
			array(), 
			THEME_VERSION, 
			'all'
		);
		array_push( $styles, 'style' );
		
		// Dashicons voor de Frontend
		array_push( $styles, 'dashicons' );
		
		// Hoofd styling voor de Frontend
		wp_register_style( 
			'main', 
			get_stylesheet_directory_uri() . '/assets/css/main.css', 
			array( 'dashicons' ), 
			THEME_VERSION, 
			'all'
		);
		array_push( $styles, 'main' );
		
		// We enqueuen alle styles
		wp_enqueue_style( $styles ); 
	}
	
	// Roep de scripts en styles registratie functie aan
	add_action( 'wp_enqueue_scripts', 'register_scripts', 11);
}

/**
 * Deze functie registreerd scripts en styling voor de backend
 */
function register_admin_scripts() {
	
	/* Scripts
   -------------------------------------------------------------------------- */
    wp_enqueue_script(
    	'admin', 
    	get_stylesheet_directory_uri().'/assets/js/admin.js',
    	array(),
		THEME_VERSION,
		true
	);
	
	/* Styling
   -------------------------------------------------------------------------- */
   	$styles = array();
	
	// De globale admin CSS
	wp_register_style( 
		'my-admin', 
		get_stylesheet_directory_uri() . '/assets/css/admin.css', 
		false, 
		THEME_VERSION
	);
	array_push( $styles, 'my-admin' );
	
	// De backend WYSIWYG editor CSS
	wp_register_style( 
		'my-editor', 
		get_stylesheet_directory_uri() . '/assets/css/editor.css', 
		false, 
		THEME_VERSION
	);
	array_push( $styles, 'my-editor' );
	
    wp_enqueue_style( $styles );
}
add_action( 'admin_enqueue_scripts', 'register_admin_scripts', 10, 0 );

?>
<?php
	/**
	 * De hoofd header template
	 *
	 * @author 		Brian de Geus - Sebwite
	 * @package 	Sebwite/BaseTheme
	 * @since		0.1
	 * @version     0.3.1
	 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
	<!--<![endif]-->
	<head>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,400italic|Vollkorn:400italic,400,700' rel='stylesheet' type='text/css'>
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <title><?php wp_title(); ?></title>
    	
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		
		<div id="wrapper-global">
			
			<header id="header-main" class="header-main">
				<div class="wrapper-content">
					<?php get_template_part('partials/nav-main'); ?>
				</div><!-- .wrapper-content -->
			</header><!-- #header-main -->
				
			<?php get_template_part('partials/hero-unit'); ?>
		
			<div id="wrapper-main" class="wrapper-main">
				
				<div class="wrapper-content">
			
					<?php 
						if( !is_front_page() ) {
							if( function_exists( 'yoast_breadcrumb' ) ) {
								yoast_breadcrumb('<p id="breadcrumbs">','</p>');
							}
						}
					?>
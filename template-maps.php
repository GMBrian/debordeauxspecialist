<?php
/**
 * Template Name: Maps template
 * 
 * De hoofd index template
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @since		0.1
 * @version     0.3.1
 */

global $template;
$template = 'maps';
 
?>
<?php get_header(); ?>
	
	<!--<div id="maps-container" class="maps-container"></div>-->

	<?php // Voor de sidebar rechts: ?>
	<?php get_template_part( 'sidebar', 'right' ); ?>
	<?php get_template_part( 'partials/loop', 'left' ); ?>
	
	<?php // Voor de sidebar links: ?>
	<?php //get_template_part( 'sidebar', 'left' ); ?>
	<?php //get_template_part( 'partials/loop', 'right' ); ?>
    
<?php get_footer(); ?>
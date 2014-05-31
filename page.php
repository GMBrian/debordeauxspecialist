<?php
/**
 * De hoofd index template
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @since		0.1
 * @version     0.3.1
 */
?>
<?php get_header(); ?>

<?php get_template_part( 'partials/loop' ); ?>
<?php get_template_part( 'sidebar', 'right' ); ?>
    
<?php get_footer(); ?>
<?php
/**
 * De single/post template
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @since		0.1
 * @version     0.3.1
 */
?>
<?php get_header(); ?>

<?php get_template_part( 'partials/loop', 'archive' ); ?>
<?php get_template_part( 'sidebar', 'right' ); ?>
    
<?php get_footer(); ?>
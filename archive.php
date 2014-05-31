<?php
/**
 * De archive template
 *
 * @author 		Brian de Geus - GeusMedia
 * @package 	GeusMedia/DeBordeauxSpecialist
 * @since		1.0
 * @version     1.0
 */
?>
<?php get_header(); ?>

<?php get_template_part( 'partials/loop', 'archive' ); ?>
<?php get_template_part( 'sidebar', 'right' ); ?>
    
<?php get_footer(); ?>
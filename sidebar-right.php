<?php
	/**
	 * De rechter sidebar
	 * 
	 * TODO: Verwijder dit commentaar of dit bestand afhankelijk van de sidebar die je gebruikt in functions.php
	 *
	 * @author 		Brian de Geus - Sebwite
	 * @package 	Sebwite/BaseTheme
	 * @since		0.3.1
	 * @version     0.3.1
	 */
?>
<aside id="sidebar-right" class="sidebar sidebar-right">
	
    <?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
    	
    	<?php dynamic_sidebar( 'sidebar-right' ); ?>
    	
    	<section class="partners">
			<h3>Onze partners</h3>
			<a class="post-nl" href="https://mijnpakket.postnl.nl/">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/img-logo-postnl.png'; ?>">
			</a>
			<a class="ideal" href="http://ideal.nl/">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/img-logo-ideal.png'; ?>">
			</a>
		</section>
    	
    <?php else: ?>
    	
    	<div class="widget filler"></div>
    	
    <?php endif; ?>
    
</aside><!-- #sidebar-left -->

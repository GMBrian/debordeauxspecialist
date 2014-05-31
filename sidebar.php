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
    	
    <?php else: ?>
    	
    	<div class="widget filler"></div>
    	
    <?php endif; ?>
    
</aside><!-- #sidebar-left -->

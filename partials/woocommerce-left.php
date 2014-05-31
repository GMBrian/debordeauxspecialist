<?php
/**
 * De loop template met content links
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @since		0.1
 * @version     0.3.1
 */
?>
<div id="wrapper-entry" class="wrapper-entry entry-left">

    <?php woocommerce_content(); ?>
    
    <?php if(is_archive() && !is_archive('product')) : ?>
   		<div class="navigation"><p><?php posts_nav_link(); ?></p></div>
	<?php endif; ?>
	
</div><!-- #wrapper-entry -->
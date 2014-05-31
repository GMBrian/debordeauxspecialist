<?php
/**
 * Geeft de metadata weer van een post
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @since		0.1
 * @version     0.3.1
 */
?>
<footer class="entry-footer">
	<div class="entry-meta">
		<span class="entry-date"><?php _e('geplaatst op ', 'theme'); ?><time class="entry-date-time" datetime="<?php echo get_the_date( 'c' ); ?>"><?php the_date(); ?></time></span>
	</div>
</footer>
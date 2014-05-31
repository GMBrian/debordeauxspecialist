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

	<h1 class="page-head">Zoekresultaten</h1>

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result' ); ?>>

				<?php
				global $post;
				$obj = get_post_type_object( get_post_type( $post) );
				?>

	            <header>
	                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	            </header>

				<div class="meta-data">
					<?php echo $obj->labels->singular_name; ?>
				</div>

	            <div class="entry-content">
	                <?php the_search_excerpt(); ?>
	            </div><!-- .entry-content -->

				<p class="read-more">
					<a class="button" href="<?php the_permalink(); ?>"><?php _e('Lees meer', 'theme'); ?> </a>
				</p>

			</article><!-- #post-ID -->
		    <hr>
        <?php endwhile; ?>
        
    <?php else : ?>
    	
    	<p><?php _e( 'Geen zoekresultaten gevonden.', 'theme' ); ?></p>
    	
    <?php endif; ?>
    
	<div class="navigation"><p><?php posts_nav_link(); ?></p></div>
	
</div><!-- #wrapper-entry -->
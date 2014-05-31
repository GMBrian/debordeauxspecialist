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
<div id="wrapper-entry" class="wrapper-entry">

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	            <header>
	                <h2 class="entry-title"><?php the_title(); ?></h2>
	            </header>

                <?php get_template_part( 'partials/entry-meta' ); ?>
	            
	            <div class="entry-content">

	                <?php if (has_post_thumbnail( get_the_ID() ) ): ?>
                        <a href="<?php the_permalink(); ?>" class="featured-image-link">
                            <?php the_post_thumbnail( 'medium' ); ?>
                        </a>
	                <?php endif; ?>

	                <?php the_archive_excerpt(); ?>

	            </div><!-- .entry-content -->
            
				<p class="read-more">
					<a class="button" href="<?php the_permalink(); ?>"><?php _e('Lees verder', 'theme'); ?></a>
				</p>

                <div class="clearfix"></div>
	            
			</article><!-- #post-ID -->
		    <hr>
        <?php endwhile; ?>
        
    <?php else : ?>
    	
    	<p><?php _e( 'Geen berichten gevonden.', 'theme' ); ?></p>
    	
    <?php endif; ?>

    <?php wp_pagenavi(); ?>
	
</div><!-- #wrapper-entry -->
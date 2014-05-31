<?php
/**
 * De loop template
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
	                <h1 class="entry-title"><?php the_title(); ?></h1>
	            </header>
	            
	            <?php if(is_single() || is_archive()) : ?>
	            	<?php get_template_part( 'partials/entry-meta' ); ?>
	            <?php endif; ?>
	            
	            <div class="entry-content">

                    <?php if (has_post_thumbnail( get_the_ID() ) ): ?>
                        <?php the_post_thumbnail( 'medium' ); ?>
                    <?php endif; ?>

	                <?php the_content(); ?>

	            </div><!-- .entry-content -->
	            
	            <?php if(is_single()) : ?>
		
					<?php //wp_list_comments(array('style' => 'div')); ?>
				 	<?php //comments_template(); ?>
				 	
	            <?php endif; ?>
	            
			</article><!-- #post-ID -->
        <?php endwhile; ?>
    <?php endif; ?>
    
    <?php if(is_archive()) : ?>
   		<div class="navigation"><p><?php posts_nav_link(); ?></p></div>
	<?php endif; ?>
	
</div><!-- #wrapper-entry -->
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

                    <p>Lees het <b>volledige recept</b> door het te downloaden.</p>

                    <p class="chef">
                        <?php
                        $recipe_terms = wp_get_post_terms( get_the_ID(), 'bdx_recipe_chef' );

                        $echo_terms = array();
                        foreach( $recipe_terms as $recipe_term ) {
                            $echo_terms[] = $recipe_term->name;
                        }
                        ?>
                        door <?php echo implode( ',', $echo_terms ); ?>
                    </p>

                    <p class="download">
                        <a target="_blank" class="big-button" href="<?php the_field( 'recept_pdf' ); ?>"><?php _e('Download recept', 'theme'); ?></a>
                    </p>

                    <div class="clearfix"></div>

	            </div><!-- .entry-content -->

                <?php $linked_products = get_field( 'aanbevolen_wijnen' ); ?>

                <?php if( $linked_products && count( $linked_products ) > 0 ) : ?>

                    <?php $product_factory = new WC_Product_Factory(); ?>

                    <div class="related products">

                        <h2>Aanbevolen wijnen bij dit recept</h2>
                        <ul class="products">

                            <?php foreach( $linked_products as $linked_product ) : ?>

                                <?php
                                $linked_product = array_shift( $linked_product );
                                $product = $product_factory->get_product( $linked_product->ID );
                                ?>

                                <li class="product">

                                    <a href="<?php echo get_permalink( $product->post->ID ); ?>" class="wp-post-image-anchor">
                                        <?php echo get_the_post_thumbnail( $product->post->ID, 'shop_catalog' ); ?>
                                    </a>

                                    <h3><?php echo $product->post->post_title; ?></h3>


                                    <span class="price"><?php echo $product->get_price_html(); ?></span>

                                </li>

                            <?php endforeach; ?>

                        </ul>
                    </div>

                <?php endif; ?>

	            <?php if(is_single()) : ?>
		
					<?php //wp_list_comments(array('style' => 'div')); ?>
				 	<?php //comments_template(); ?>
				 	
	            <?php endif; ?>
	            
			</article><!-- #post-ID -->
        <?php endwhile; ?>
    <?php endif; ?>
	
</div><!-- #wrapper-entry -->
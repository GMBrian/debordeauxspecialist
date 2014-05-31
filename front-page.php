<?php
/**
 * Template voor thuis pagina (/home)
 */
?>
<?php get_header(); ?>

<?php // Voor de sidebar rechts: ?>

<div id="wrapper-entry" class="wrapper-entry entry-left">

<?php if(!is_user_logged_in()) : ?>
    <?php if( have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>">
                <h1 class="page-head"><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
    <hr>
    <h2 class="caps-head tight-head"><?php _e( 'Uitgelichte wijnen', 'theme' ); ?></h2>
    <small class="page-head full-width"><?php echo sprintf( __('Hieronder staan onze uitgelichte wijnen. Ga voor het volledige assortiment naar de <a href="%s">winkel</a>.', 'theme' ), home_url( '/winkel' ) ); ?></small>


    <?php
    $featured_query = new WP_Query( array(
        'post_status' => 'publish',
        'post_type' => 'product',
        'meta_key' => '_featured',
        'meta_value' => 'yes',
        'posts_per_page' => -1
    ) );
    ?>

    <ul class="products">
        <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>

            <?php wc_get_template_part( 'content', 'product' ); ?>

        <?php endwhile; // end of the loop. ?>
    </ul>

    <?php else: ?>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div id="post-<?php the_ID(); ?>">
                    <h1 class="page-head"><?php the_title(); ?></h1>
                    <p>Welkom <a href="<?php echo home_url('/mijn-account/'); ?>"><?php the_username(); ?></a>,</p>
                    <p>Vanaf hier kunt u navigeren naar onze <a href="<?php echo home_url('/nieuws/'); ?>">nieuwsberichten</a> en <a href="<?php echo home_url('/columns/'); ?>">columns</a>. Hieronder vindt u recente toevoegingen aan <a href="<?php echo home_url('/shop/'); ?>">de winkel</a>. Vergeet niet een kijkje te nemen naar de <a href="<?php echo home_url('/activiteit/toekomstig/'); ?>">aankomende activiteiten</a> zodat u geen proeverijen mist.
                    </p>
                    <hr>
                    <!--<div class="body-shadow">-->
                    <h2 class="caps-head no-margin">Recente berichten</h2>
                    <?php
                        $args = array(
                            'numberposts' => 8,
                            'offset' => 0,
                            'orderby' => 'post_date',
                            'order' => 'DESC',
                            'post_type' => array(
                                    'post',
                                    'bdx_recipe'
                                ),
                            'post_status' => 'publish',
                            'suppress_filters' => true
                        );
                        $recent_posts = wp_get_recent_posts($args, $output = ARRAY_A);
                    ?>
                    <ul class="recent-posts">
                        <?php foreach($recent_posts as $post) : ?>
                            <?php
                                //pre($post);
                                if($post['post_type'] == 'bdx_recipe') {
                                    $category = 'Recepten';
                                }
                                else {
                                    $category = get_the_category($post['ID']);
                                    $category = $category[0]->cat_name;
                                }
                            ?>
                            <li>
                                <span class="date"><?php echo mysql2date('j M, Y', $post['post_date']); ?></span>
                                <span class="title"><a href="<?php echo get_permalink($post['ID']); ?>"><?php echo $post['post_title'] ?></a></span>
                                <span class="type"><?php echo $category; ?></span>
                                <div class="clearfix"></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <!--</div>-->
                    <hr>
                    <h2 class="caps-head tight-head"><?php _e( 'Uitgelichte wijnen', 'theme' ); ?></h2>
                    <small class="page-head full-width"><?php echo sprintf( __('Hieronder staan onze uitgelichte wijnen. Ga voor het volledige assortiment naar de <a href="%s">winkel</a>.', 'theme' ), home_url( '/winkel' ) ); ?></small>
                    <?php //$recent = get_recent_product_ids(); ?>

                    <?php
                        $featured_query = new WP_Query( array(
                            'post_status' => 'publish',
                            'post_type' => 'product',
                            'meta_key' => '_featured',
                            'meta_value' => 'yes',
                            'posts_per_page' => -1
                        ) );
                    ?>

                    <ul class="products">
                        <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>

                            <?php wc_get_template_part( 'content', 'product' ); ?>

                        <?php endwhile; // end of the loop. ?>
                    </ul>
                </div><!-- #post-ID -->
            <?php endwhile; ?>
        <?php endif; ?>
    <?php endif; ?>
    <div class="clearfix"></div>

</div><!-- #wrapper-entry -->

<?php get_template_part( 'sidebar', 'right' ); ?>
	
<?php get_footer(); ?>

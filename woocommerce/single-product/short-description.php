<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

if ( ! $post->post_excerpt && ! $post->post_content ) return;
?>
<div class="description" itemprop="description">


    <?php if( $post->post_excerpt ) : ?>
        <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
    <?php else : ?>
        <?php the_archive_excerpt(); ?>
    <?php endif; ?>
</div>
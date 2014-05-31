<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span>.</span>

	<?php endif; ?>

	<?php echo $product->get_categories( ', ', '<span class="posted_in category">' . _n( '', '', $cat_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( '', '', $tag_count, 'woocommerce' ) . ' ', '</span>' ); ?>

    <?php
        $attribute_names = array( 'pa_druif', 'pa_inhoud', 'pa_jaar' ); // Insert attribute names here

        foreach ( $attribute_names as $attribute_name ) {
            $taxonomy = get_taxonomy( $attribute_name );

            if ( $taxonomy && ! is_wp_error( $taxonomy ) ) {
                $terms = wp_get_post_terms( $post->ID, $attribute_name );
                $terms_array = array();

                if ( ! empty( $terms ) ) {
                    foreach ( $terms as $term ) {
                        //$archive_link = get_term_link( $term->slug, $attribute_name );

                        $shop_page_id = get_option( 'woocommerce_shop_page_id' );
                        if ( $shop_page_id ) {
                            $shop_page_url = get_permalink( $shop_page_id );

                            $shop_page_url .= '?filter_' . str_replace( 'pa_', '', $attribute_name ) . '=' . $term->term_id;
                        }

                        $full_line = '<a href="' . $shop_page_url . '">'. $term->name . '</a>';
                        array_push( $terms_array, $full_line );
                    }
                }

                if( !empty( $terms_array ) ) {
                    echo '<span class="attribute ' . $attribute_name . '">' . implode( $terms_array, ', ' ) . '</span>';
                }
            }
        }
    ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
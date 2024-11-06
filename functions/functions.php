<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! function_exists( 'cpbw_product_badge' ) ) {
    // Add custom product badge to WooCommerce product thumbnails
    add_action('woocommerce_before_shop_loop_item_title', 'cpbw_product_badge', 10);

    function cpbw_product_badge() {
        global $product;

        // Check if the product is on sale and add badge with translation
        if ($product->is_on_sale()) {
            echo '<span class="cpbw-custom-badge">' . esc_html__('On Sale', 'custom-product-badge-for-woocommerce') . '</span>';
        }
    }

}
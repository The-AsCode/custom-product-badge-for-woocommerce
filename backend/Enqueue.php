<?php

namespace CPBW\Backend;

class Enqueue {

    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'admin_script'], 10, 1);
    }

    /**
     * Enqueue styles and scripts on the admin dashboard.
     *
     * @param string $page The current admin page.
     * @return void
     */
    public function admin_script( $page ) {

        // // Enqueue the CSS file.
        // wp_enqueue_style('ascode-woo-calculator-css', CPBW_ASSETS . '/admin/css/output.css');

        // Check if the current admin page matches your target page.
        if ( $page === 'toplevel_page_cpbw' ) {
             wp_enqueue_style('cpbw-dashboard-css', CPBW_URL . '/backend/views/assets/tailwind.css', [], '1.0.0', 'all');

            // Enqueue the JavaScript file.
            wp_enqueue_script('cpbw-dashboard', CPBW_ASSETS . '/build/plugin-admin.js', ['wp-element'], '1.0.0' , true);
            wp_localize_script('cpbw-dashboard',
                'CPBW',
                array(
                    'rest_nonce'  => wp_create_nonce( 'wp_rest' ),
                    'rest_url' => rest_url('cpbw/v1'),
                    'badge_image_file' => CPBW_URL . '/backend/views/assets/badge/badgeImageData.json',
                    'badge_image_file' => CPBW_URL,
                    'is_pro' => is_plugin_active( 'cpbw-for-woocommerce-pro/cpbw-for-woocommerce-pro.php' ) ? true : false,
                ));

            if (function_exists('wp_enqueue_media')) {
                wp_enqueue_media();
             }
        }
    }
}
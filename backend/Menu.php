<?php

namespace CPBW\Backend;

/**
 * The menu handler class
 */
class Menu {

    public function __construct() {
        add_action('admin_menu', [$this, 'cpbw_admin_menu']);
    }

    public function cpbw_admin_menu() {
        add_menu_page(
            __('CPBW', 'custom-product-badge-for-woocommerce'),
            __('CPBW', 'custom-product-badge-for-woocommerce'),
            'manage_options',
            'cpbw',
            [$this, 'plugin_page'],
            'dashicons-welcome-widgets-menus' // Icon for the menu item
        );
    }

    /**
     * Callback function to display the plugin page.
     */
    public function plugin_page() {
        // Load the view from the plugin directory.
        require_once CPBW_DIR_PATH . '/backend/views/admin-view.php';
    }
}
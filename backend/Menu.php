<?php

namespace ProductBadge\Backend;

class Menu {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu']);
    }

    public function add_menu() {
        add_menu_page(
            'Product Badge',
            'Product Badge',
            'manage_options',
            'product-badge',
            [$this, 'product_badge_page'],
            'dashicons-cart',
            10
        );
    }

    public function product_badge_page() {
        include CUSTOM_PRODUCT_BADGE_PATH . '/backend/views/admin-view.php';
    }
}
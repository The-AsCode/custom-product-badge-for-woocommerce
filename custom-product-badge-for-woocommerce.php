<?php
/**
 * Plugin Name: Custom Product Badge for WooCommerce
 * Plugin URI: https://github.com/The-AsCode/custom-product-badge-for-woocommerce
 * Description: A simple product comparison plugin for WooCommerce.
 * Version: 1.0.0
 * Author: Shop ManagerX
 * Author URI: https://osmanhaideradnan.wordpress.com/
 * License: GPLv3
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Text Domain: custom-product-badge-for-woocommerce
 * Domain Path: languages/
 * Requires Plugins: woocommerce
 **/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Check if the Composer autoload file exists, and if not, show an error message.
if ( ! file_exists(__DIR__ . '/vendor/autoload.php' ) ) {
    die('Please run `composer install` in the main plugin directory.');
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Plugin main class
 */
final class Custom_Product_Badge {
    const cpbw_version = '1.0.0';

    // Private constructor to enforce singleton pattern.
    private function __construct() {
        $this->define_constants();

        // Register activation hook.
        register_activation_hook(__FILE__, [$this, 'activate']);

        // Hook into the upgrader process to handle plugin updates
        add_action('upgrader_process_complete', array($this, 'update'), 10, 2);

        // Hook into the 'plugins_loaded' action to initialize the plugin.
        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    //public static function init() {
    public static function init() {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    // Define the plugin constants.
    private function define_constants() {
        define('CUSTOM_PRODUCT_BADGE_VERSION', self::cpbw_version);
        define('CUSTOM_PRODUCT_BADGE_FILE', __FILE__);
        define('CUSTOM_PRODUCT_BADGE_PATH', __DIR__);
        define('CUSTOM_PRODUCT_BADGE_URL', plugins_url('', CUSTOM_PRODUCT_BADGE_FILE));
        define('CUSTOM_PRODUCT_BADGE_ASSETS', CUSTOM_PRODUCT_BADGE_URL . '/assets');
    }

    //activate the plugin
    public function activate() {
        $installed = get_option('custom_product_badge_installed');

        if (!$installed) {
            update_option('custom_product_badge_installed', time());
        }

        update_option('custom_product_badge_version', CUSTOM_PRODUCT_BADGE_VERSION);
    }

    //update the plugin
    public function update($upgrader_object, $options) {
        if ($options['action'] == 'update' && $options['type'] == 'plugin') {
            foreach ($options['plugins'] as $plugin) {
                if ($plugin == CUSTOM_PRODUCT_BADGE_FILE) {
                    $this->activate();
                }
            }
        }
    }

    //initialize the plugin
    public function init_plugin() {
        if( is_admin() ) {
            new ProductBadge\Backend\Menu();
        }
    }
}

//Initialize the main plugin

function custom_product_badge() {
    return Custom_Product_Badge::init();
}

//kick-off the plugin
custom_product_badge();
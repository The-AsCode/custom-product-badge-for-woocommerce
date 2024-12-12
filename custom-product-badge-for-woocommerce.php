<?php

/** 
 * Plugin Name:       Custom Product Badge for WooComemrce
 * Plugin URI:        https://shopmanagerx.wordpress.com/
 * Description:       The Ultimate WooCommerce Plugin for Custom Badge Control.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Shop ManagerX
 * Author URI:        https://osmanhaideradnan.wordpress.com/
 * License:           GPLv3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       custom-product-badge-for-woocommerce
 * Domain Path:       /languages
 * * Requires Plugins: woocommerce
 * @package     Custom Product Badge For WooCommerce
 * @copyright   Copyright (C) 2023 Shop Manager X. All rights reserved.
 * @license     GPLv3 or later
 * @since       1.0.0
 */

// Ensure the file is not accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Check if the Composer autoload file exists, and if not, show an error message.
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    die('Please run `composer install` in the main plugin directory.');
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Plugin main class
 */
final class CPBW_Main {

    /**
     * Define plugin version
     * 
     * @var string
     */
    const cpbw_version = '1.0.0';

    // Private constructor to enforce singleton pattern.
    private function __construct()
    {
        $this->define_constants();

        // Register activation hook.
        register_activation_hook(__FILE__, [$this, 'activate']);

        // Hook into the upgrader process to handle plugin updates
        add_action('upgrader_process_complete', array($this, 'update'), 10, 2);

        // Hook into the 'plugins_loaded' action to initialize the plugin.
        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Singleton instance
     *
     * @return store_manager
     */
    public static function init() {
        static $instance = false;
        
        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define constants for the plugin.
     *
     * @return void
     */
    function define_constants() {
        define('CPBW_VERSION', self::cpbw_version);
        define('CPBW_FILE', __FILE__);
        define('CPBW_DIR_PATH', plugin_dir_path(CPBW_FILE));
        define('CPBW_URL', plugin_dir_url(CPBW_FILE));
        define('CPBW_ASSETS', CPBW_URL . 'assets');
        define('CPBW_BACKEND_ASSETS', CPBW_URL . 'assets');
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    function activate() {
        update_option('store_manager_version', CPBW_VERSION);
        // Set an option to store the installation time.
        $installed = get_option('shop_manager_install_time');

        if (!$installed) {
            update_option('store_manager_install_time', time());
        }

        new CPBW\Backend\ActDeact();
    }

    /**
     * Update method to be called on plugin update
     * 
     * @param $upgrader_object
     * @param $options
     * 
     * @return void
     */
    public function update($upgrader_object, $options) {
        if ($options['action'] == 'update' && $options['type'] == 'plugin') {
            // Check if plugin is being updated
            $our_plugin = plugin_basename(__FILE__);
            if (isset($options['plugins']) && in_array($our_plugin, $options['plugins'])) {
                new \CPBW\Backend\ActDeact();
            }
        }
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
        // $badge_base_dir = ABSPATH . 'wp-content/plugins/custom-product-badge-for-woocommerce/backend/views/assets/badge/badge-images';
        // $badge_json_file = ABSPATH . 'wp-content/plugins/custom-product-badge-for-woocommerce/backend/views/assets/badge/badgeImageData.json';
        if (is_admin()) {
            new CPBW\Backend\Menu();
            // new CPBW\App\Image\Image( $badge_base_dir, $badge_json_file);

            //Check plugin update and change the required need.
            CPBW\Backend\ActDeact::plugin_check_update();
        }

        new CPBW\Rest\Api();
        new CPBW\Backend\Enqueue();
    }
}

/**
 * Initialize the main plugin.
 *
 * @return shop_manager
 */
function cpbw_load()
{
    return CPBW_Main::init();
}

// Kick-off the plugin.
cpbw_load();

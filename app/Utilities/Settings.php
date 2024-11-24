<?php

namespace CPBW\App\Utilities;

class Settings {

	/**
	 * Get settings.
	 * If the key is not found, return all settings.
	 * If the key is 'all', return all settings.
	 * If the key is 'default', return default settings.
	 * If the key is found, return the value.
	 * If the key is not found, return false.
	 *
	 * @param string $key Settings Key.
     * @return array|string|\WP_Error Settings.
	 */
	public static function get( $key = 'all' ) {
		$default = array(
			'show_wc_sale_badge'            => 'false',
			'show_badge_in_product_page'    => 'true',
		);

		/**
		 * Add defaults without changing the core values.
		 *
		 * @param array $defaults
		 * @since 3.3.11
		 */
		$default = wp_parse_args( apply_filters( 'cpbw_settings', $default ), $default );

		if ( 'default' === $key ) {
			return $default;
		}

		$get_settings = get_option( 'cpbw_settings', array() );

		$settings = wp_parse_args( $get_settings, $default );

		if ( 'all' === $key || empty( $key ) ) {
			return $settings;
		}

		if ( array_key_exists( $key, $settings ) ) {
			return $settings[ $key ];
		}

		return new \WP_Error(
			'rest_not_found',
			__( 'Sorry, Invalid Settings Key.', 'custom-product-badge-for-woocommerce' ),
			array( 'status' => 400 )
		);
	}

	/**
	 * Save settings.
	 *
	 * @param array $args Settings.
     * @return bool
	 * @throws \Exception Invalid Settings Key.
	 * @since 1.0.0
	 */
	public static function save( $args ) {
		$settings = get_option( 'cpbw_settings', self::get() );

		$new_settings = wp_parse_args( $args, $settings );

		return update_option( 'cpbw_settings', $new_settings );
	}

}
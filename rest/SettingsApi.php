<?php

namespace CPBW\Rest;
use WP_REST_Controller;
use WP_REST_Server;
use CPBW\App\Utilities\Settings;

class SettingsApi extends WP_REST_Controller {

    /**
     * The namespace of this controller's route.
     * 
     * @var string
     * @since 1.0.0
     */
    public function register_routes() {
        register_rest_route(
            Api::NAMESPACE_NAME . '/' . Api::VERSION,
            '/' . Api::SETTINGS_ROUTE_NAME . '/',
            array(
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this,'get_item'),
                    'permission_callback' => array( $this,'permissions_check' ),
                    'args'                => $this->get_collection_params(),
                ),
                array(
                    'methods'             => WP_REST_Server::EDITABLE,
                    'callback'            => array( $this,'update_item'),
                    'permission_callback' => array( $this,'permissions_check' ),
                    'args'                => $this->get_collection_params(),
                ),
			)
		);
	}

    /**
     * Checks if a given request has access to read settings.
     * 
     * @return bool
     */
    public function permissions_check() {
        return current_user_can( 'manage_options' );
    }

    /**
	 * Retrieves a list of address items.
	 *
	 * @param \WP_REST_Request $request Full data about the request.
     * @return \WP_REST_Response|\WP_Error
	 * @throws \Exception If the settings is invalid.
	 */
	public function get_item( $request ) {
		$settings = Settings::get();

		if ( is_wp_error( $settings ) ) {
			return $settings;
		}

		$response = $this->prepare_item_for_response( $settings, $request );
		$data     = $this->prepare_response_for_collection( $response );

		$total = 0;

		if ( is_array( $settings ) ) {
			$total = count( $settings );
		}

		$response = rest_ensure_response( $data );

		$response->header( 'X-WP-Total', (int) $total );
		$response->header( 'X-WP-TotalPages', (int) $total );

		return $response;
	}

	/**
	 * Updates one item from the collection.
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function update_item( $request ) {
		$prepared_settings = (array) $this->prepare_item_for_database( $request );

		$updated = Settings::save( $prepared_settings );

		if ( ! $updated ) {
			return new \WP_Error(
				'rest_not_updated',
				__( 'Sorry, settings could not be updated.', 'custom-product-badge-for-woocommerce' ),
				array( 'status' => 400 )
			);
		}

		$settings = Settings::get();

		if ( is_wp_error( $settings ) ) {
			return $settings;
		}

		$response = $this->prepare_item_for_response( $settings, $request );

		return rest_ensure_response( $response );
	}

	/**
	 * Prepares the item for the REST response.
	 *
	 * @param array|string     $item    WordPress' representation of the item.
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function prepare_item_for_response( $item, $request ) {

		$data = array();

		$fields = $this->get_fields_for_response( $request );

		if ( is_array( $fields ) && is_array( $item ) && in_array( 'show_wc_sale_badge', $fields, true ) ) {
			$data['show_wc_sale_badge'] = $item['show_wc_sale_badge'];
		}

		if ( is_array( $fields ) && is_array( $item ) && in_array( 'show_badge_in_product_page', $fields, true ) ) {
			$data['show_badge_in_product_page'] = $item['show_badge_in_product_page'];
		}

		$context = 'view';

		if ( is_string( $request['context'] ) ) {
			$context = $request['context'];
		}

		$data = $this->filter_response_by_context( $data, $context );

		return rest_ensure_response( $data );
	}

	/**
	 * Retrieves the contact schema, conforming to JSON Schema.
	 *
	 * @return array
	 */
	public function get_item_schema() {
		if ( $this->schema ) {
			return $this->add_additional_fields_schema( $this->schema );
		}

		$schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'contact',
			'type'       => 'object',
			'properties' => array(
				'show_wc_sale_badge'      => array(
					'description' => __( 'Hide WooCommerce Sale badge.', 'custom-product-badge-for-woocommerce' ),
					'type'        => 'string',
					'context'     => array(
						'view',
						'edit',
					),
				),
				'show_badge_in_product_page' => array(
					'description' => __( 'Show badge on product page.', 'custom-product-badge-for-woocommerce' ),
					'type'        => 'string',
					'context'     => array(
						'view',
						'edit',
					),
				),
			),
		);

		$this->schema = $schema;

		return $this->add_additional_fields_schema( $this->schema );
	}

	/**
	 * Retrieves the query params for collections.
	 *
	 * @return array
	 */
	public function get_collection_params() {
		$params = parent::get_collection_params();

		unset( $params['search'], $params['per_page'], $params['page'] );

		return $params;
	}

	/**
	 * Get the setting, if the key is valid.
	 *
	 * @param string $key Supplied ID.
	 * @return array|string|\WP_Error
	 */
	protected function get_settings( $key ) {
		$setting = Settings::get( $key );

		if ( ! $setting ) {
			return new \WP_Error(
				'rest_setting_invalid_key',
				__( 'Invalid Setting Key.', 'custom-product-badge-for-woocommerce' ),// phpcs:ignore
				array( 'status' => 404 )
			);
		}

		return $setting;
	}

	/**
	 * Prepares one item for create or update operation.
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return object
	 */
	protected function prepare_item_for_database( $request ) {
		$prepared = array();

		if ( isset( $request['settings_1'] ) ) {
			$prepared['settings_1'] = $request['settings_1'];
		}

		if ( isset( $request['settings_2'] ) ) {
			$prepared['settings_2'] = $request['settings_2'];
		}

		if ( isset( $request['settings_3'] ) ) {
			$prepared['settings_3'] = $request['settings_3'];
		}

		if ( isset( $request['show_wc_sale_badge'] ) ) {
			$prepared['show_wc_sale_badge'] = $request['show_wc_sale_badge'];
		}

		if ( isset( $request['show_badge_in_product_page'] ) ) {
			$prepared['show_badge_in_product_page'] = $request['show_badge_in_product_page'];
		}

		return (object) $prepared;
	}

}
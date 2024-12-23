<?php

namespace CPBW\Rest;

/**
 * Class Api
 *
 * @package Woo_Manager_X\Rest
 */
Class Api {

    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_rest_api' ) );
    }

    public const NAMESPACE_NAME      = 'cpbw';
	public const VERSION             = 'v1';
	public const PRODUCT_ROUTE_NAME = 'product';
	public const SEARCH_ROUTE_NAME = 'search';
	public const DROPDOWN_ROUTE_NAME = 'dropdown';
	public const FILTER_ROUTE_NAME = 'filters';
	public const BADGE_ROUTE_NAME = 'badges';
	public const SETTINGS_ROUTE_NAME = 'settings';

    /**
	 * Register REST API
	 *
	 * @return void
	 */
	public function register_rest_api() {
		//wp-json/cpbw/v1/settings
		$settings = new SettingsApi();
		$settings->register_routes();

		//wp-json/cpbw/v1/product?per_page=20&category=slug&type=type&page=1&search=product_name&status=all/managed/out_of_stock/low_stock
		//wp-json/cpbw/v1/product/product_id?manage_stock=yes/no&stock_quantity=20&stock_status=instock/outofstock/onbackorder&backorders=yes/no/notify
		$product = new ProductApi;
		$product->register_route();

		//wp-json/cpbw/v1/search/product?search=product_name
		//wp-json/cpbw/v1/search/category?search=category_name
		//wp-json/cpbw/v1/search/search/tag?search=tag_name
		//wp-json/cpbw/v1/search/attribute?search=attribute_name
		$search = new SrearchApi();
		$search->register_routes();

		//wp-json/cpbw/v1/dropdown/?search=conditions
		//wp-json/cpbw/v1/dropdown/?search=filters
		//wp-json/cpbw/v1/dropdown/?search=products
		$dropdown = new DropDownApi();
		$dropdown->register_routes();

		//wp-json/cpbw/v1/filters/43
		//wp-json/cpbw/v1/filters
		$filter = new FilterApi();
		$filter->register_routes();

		//wp-json/cpbw/v1/badges
		$badge = new BadgeApi();
		$badge->register_routes();
	}
}
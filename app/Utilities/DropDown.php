<?php // phpcs:ignore

/**
 * DropDown Utility
 *
 * @package    Store Manager
 * @subpackage App\Utility
 * @since      1.0.0
 * @category   Utility
 */

namespace CPBW\App\Utilities;

class DropDown {// phpcs:ignore

	/**
	 * Select Products to add discount.
	 *
	 * @return array
	 */
	public static function products()
	{
		return array(
			'all_products' => esc_html__('All Products', 'custom-product-badge-for-woocommerce'),
			'products' => esc_html__('Few Products', 'custom-product-badge-for-woocommerce'),
		);
	}

	/**
	 * Conditions.
	 *
	 * @param string $type Condition Type to compare. Acceptable values:
	 *                     'string' string type conditions
	 *                     'number' number type conditions
	 *                     'date' date type conditions
	 *                     'select' list type conditions.
	 * @param string $key Condition Key to get specific condition.
	 * @return array
	 */
	public static function conditions($type = null, $key = null)
	{// phpcs:ignore
		$condition = array(
			'equal' => 'Equal',
			'not_equal' => 'Not Equal',
			'contain' => 'Contain',
			'not_contain' => 'Does Not Contain',
			'start_with' => 'Start With',
			'end_with' => 'End With',
			'greater' => 'Greater Than',
			'greater_equal' => 'Greater Than or Equal',
			'lesser' => 'Less Than',
			'lesser_equal' => 'Less Than or Equal',
			'between' => 'Between',
			'date_between' => 'Date Between',
			'within_past' => 'Within Past',
			'earlier_than' => 'Earlier Than',
			'in_list' => 'In List',
			'not_in_list' => 'Not In List',
		);

		if ('string' === $type) {
			unset(
				$condition['in_list'],
				$condition['not_in_list'],
				$condition['greater'],
				$condition['greater_equal'],
				$condition['lesser'],
				$condition['lesser_equal'],
				$condition['between'],
				$condition['date_between'],
				$condition['within_past'],
				$condition['earlier_than']
			);
		}

		if ('number' === $type) {
			unset(
				$condition['in_list'],
				$condition['not_in_list'],
				$condition['date_between'],
				$condition['within_past'],
				$condition['earlier_than'],
				$condition['start_with'],
				$condition['end_with']
			);
		}

		if ('select' === $type) {
			unset(
				$condition['contain'],
				$condition['not_contain'],
				$condition['equal'],
				$condition['not_equal'],
				$condition['greater'],
				$condition['greater_equal'],
				$condition['lesser'],
				$condition['lesser_equal'],
				$condition['between'],
				$condition['date_between'],
				$condition['within_past'],
				$condition['earlier_than'],
				$condition['start_with'],
				$condition['end_with']
			);
		}

		if ('date' === $type) {
			unset(
				$condition['in_list'],
				$condition['not_in_list'],
				$condition['contain'],
				$condition['not_contain'],
				$condition['start_with'],
				$condition['end_with']
			);
		}

		if (is_array($condition)) {
			return $condition;
		}

		return array();
	}

	/**
	 * Prepare Filters for frontend appearance.
	 *
	 * @param string $title Filter Title.
	 *
	 * @param string $condition_type Condition Type to compare. Acceptable values:
	 *                                                  'string' string type conditions
	 *                                                  'number' number type conditions
	 *                                                  'date' date type conditions
	 *                                                  'date' date type conditions
	 *                                                  'select' list type conditions.
	 *
	 * @param string|array $input_type Input Filed for compare value. Acceptable values:
	 *                                            'text' for input[type=text]
	 *                                            'number' for input[type=number]
	 *                                            'date' for input[type=datetime-local]
	 *
	 *                                      For 'select' dropdown, there are two options available:
	 *
	 *                                      For manual options:
	 *                                      [
	 *                                      'type' => 'select',
	 *                                      'option_type' => 'manual',
	 *                                      'multiple' => true,
	 *                                      'options' => ['key' => 'value']
	 *                                      ]
	 *                                      OR For api options:
	 *                                      [
	 *                                      'type' => 'select',
	 *                                      'option_type' => 'api',
	 *                                      'multiple' => true,
	 *                                      'endpoint' => 'https://example.com/api/endpoint'
	 *                                      ].
	 *
	 * @param string $component Component to load into frontend. Acceptable values:
	 *                                                  'string' for string type conditions
	 *                                                  'number' for number type conditions
	 *                                                  'date' for date type conditions
	 *                                                  'select' for list type conditions.
	 * @return array                    Filter Array
	 *                                  [0]=>[
	 *                                      [optionGroup] => Filter Group Title,
	 *                                      [options] => [
	 *                                          'attribute' => [ // Attribute key to compare with. Example: 'id',
	 *                                          'title', 'sku'.
	 *                                                  'title' => 'Filter Title',
	 *                                                  'component' => 'string',
	 *                                                  'condition' => [available conditions from self::Conditions()]
	 *                                                  'input_type' => 'text',
	 *                                                  'fields' => [
	 *                                                      'compare' => '',
	 *                                                      'condition' => '',
	 *                                                      'compare_with' => '',
	 *                                                      'operator' => '',
	 *                                                   ]
	 *                                              ]
	 *                                  ].
	 */
	public static function prepare_filters(
		$title,
		$condition_type = 'string',
		$input_type = 'text',
		$component = 'string'
	)
	{
		$fields = array(
			'compare' => '',
			'condition' => '',
			'compare_with' => '',
			'operator' => '',
		);

		return array(
			'title' => $title,// phpcs:ignore
			'component' => $component,
			'condition' => self::Conditions($condition_type),
			'input_type' => $input_type, // Input Filed Type. Example values -> HTML Input Type
			'fields' => $fields,
		);
	}

	/**
	 * Get All Filters.
	 * Check the phpdoc comments of prepare_filters() method for details.
	 *
	 * @return array
	 */
	public static function filters()
	{ // phpcs:ignore
		$filter_attributes = array();

		$primary_attributes = array(
			'optionGroup' => __('Product', 'custom-product-badge-for-woocommerce'),
			'options' => array(
				'id' => self::prepare_filters('ID', '', 'number'),
				'sku' => self::prepare_filters('SKU'),
				'title' => self::prepare_filters('Title'),
				'description' => self::prepare_filters('Description'),
				'short_description' => self::prepare_filters('Short Description'),
				'attributes' => self::prepare_filters(
					'Attributes',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'api',
						'multiple' => true,
						'endpoint' => get_site_url(null, '/wp-json/smx/v1/search/attribute/?search='),
					)
				),
				'categories' => self::prepare_filters(
					'Categories',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'api',
						'multiple' => true,
						'endpoint' => get_site_url(null, '/wp-json/smx/v1/search/category/?search='),
					)
				),
				'tags' => self::prepare_filters(
					'Tags',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'api',
						'multiple' => true,
						'endpoint' => get_site_url(null, '/wp-json/smx/v1/search/tag/?search='),
					)
				),
				'link' => self::prepare_filters('URL'),
				'availability' => self::prepare_filters('Availability'),
				'quantity' => self::prepare_filters('Quantity', 'number'),
				'stock_status' => self::prepare_filters(
					'Stock Status',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'manual',
						'multiple' => true,
						'options' => wc_get_product_stock_status_options(),
					)
				),
				'weight' => self::prepare_filters('Weight'),
				'weight_unit' => self::prepare_filters(
					'Weight Unit',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'manual',
						'multiple' => false,
						'options' => array(
							'kg' => esc_html__('kg', 'custom-product-badge-for-woocommerce'),
							'g' => esc_html__('g', 'custom-product-badge-for-woocommerce'),
							'lb' => esc_html__('lb', 'custom-product-badge-for-woocommerce'),
							'oz' => esc_html__('oz', 'custom-product-badge-for-woocommerce'),
						),
					)
				),
				'width' => self::prepare_filters('Width'),
				'height' => self::prepare_filters('Height'),
				'length' => self::prepare_filters('Length'),
				'type' => self::prepare_filters(
					'Product Type',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'manual',
						'multiple' => true,
						'options' => wc_get_product_types(),
					)
				),
				'visibility' => self::prepare_filters(
					'Visibility',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'manual',
						'multiple' => true,
						'options' => wc_get_product_visibility_options(),
					)
				),
				'rating_total' => self::prepare_filters('Total Rating'),
				'rating_average' => self::prepare_filters('Average Rating'),
				'author_name' => self::prepare_filters(
					'Author Name',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'api',
						'multiple' => true,
						'endpoint' => get_site_url(null, '/wp-json/smx/v1/search/customer/?search='),
					)
				),
				'author_email' => self::prepare_filters(
					'Author Email',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'api',
						'multiple' => true,
						'endpoint' => get_site_url(null, '/wp-json/smx/v1/search/customer/?search='),
					)
				),
				'date_created' => self::prepare_filters('Date Created', 'date', 'date'),
				'date_updated' => self::prepare_filters('Date Updated', 'date', 'date'),

				'product_status' => self::prepare_filters(
					'Status',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'manual',
						'multiple' => false,
						'options' => array(
							'publish' => esc_html__('Publish', 'custom-product-badge-for-woocommerce'),
							'draft' => esc_html__('Draft', 'custom-product-badge-for-woocommerce'),
							'pending' => esc_html__('Pending', 'custom-product-badge-for-woocommerce'),
							'private' => esc_html__('Private', 'custom-product-badge-for-woocommerce'),
						),
					)
				),
				'featured_status' => self::prepare_filters(
					'Featured Status',
					'select',
					array(
						'type' => 'select',
						'option_type' => 'manual',
						'multiple' => false,
						'options' => array(
							'yes' => esc_html__('Yes', 'custom-product-badge-for-woocommerce'),
							'no' => esc_html__('No', 'custom-product-badge-for-woocommerce'),
						),
					)
				),
			),
		);
		$filter_attributes[] = $primary_attributes;

		$price_attributes = array(
			'optionGroup' => esc_html__('Price', 'custom-product-badge-for-woocommerce'),
			'options' => array(
				'currency' => self::prepare_filters('Currency'),
				'regular_price' => self::prepare_filters('Regular Price', 'number', 'number'),
				'price' => self::prepare_filters('Price', 'number', 'number'),
				'sale_price' => self::prepare_filters('Sale Price', 'number', 'number'),
				'regular_price_with_tax' => self::prepare_filters('Regular Price With Tax', 'number', 'number'),
				'price_with_tax' => self::prepare_filters('Price With Tax', 'number', 'number'),
				'sale_price_with_tax' => self::prepare_filters('Sale Price With Tax', 'number', 'number'),
				'sale_price_sdate' => self::prepare_filters('Sale Start Date', 'number', 'number'),
				'sale_price_edate' => self::prepare_filters('Sale End Date', 'number', 'number'),
			),
		);

		$filter_attributes[] = $price_attributes;

		// Product Global Attributes
		$filter_attributes[] = self::get_global_attributes();

		// Product Custom Attributes
		$customer_attributes = self::get_custom_attributes();

		if (!empty($customer_attributes)) {
			$filter_attributes[] = $customer_attributes;
		}

		// Product Taxonomies
		$taxonomies = self::get_all_taxonomy();

		if (!empty($taxonomies)) {
			$filter_attributes[] = $taxonomies;
		}

		// ACF Plugin custom fields getACFAttributes
		$acf_fileds = self::get_acf_attributes();

		if (!empty($acf_fileds)) {
			$filter_attributes[] = $acf_fileds;
		}

		// Custom Fields & Post Metas
		$product_metas = self::get_product_meta_Key_attributes();

		if (!empty($product_metas)) {
			$filter_attributes[] = $product_metas;
		}

		// Tax and Shipping Attributes
		$tax_shipping = array(
			'optionGroup' => esc_html__('Tax and Shipping', 'custom-product-badge-for-woocommerce'),
			'options' => array(
				'tax_class' => self::prepare_filters('Tax Class'),
				'tax_status' => self::prepare_filters('Tax Status'),
				'shipping_class' => self::prepare_filters('Shipping Class'),
			),
		);
		$filter_attributes[] = $tax_shipping;

		/**
		 * Subscription Attributes
		 * Add subscription attributes if WooCommerce Subscription plugin installed.
		 *
		 * @link https://woocommerce.com/products/woocommerce-subscriptions/
		 */
		if (class_exists('WC_Subscriptions')) {
			$subscription_attributes = array(
				'optionGroup' => esc_html__('Subscription & Installment', 'custom-product-badge-for-woocommerce'),
				'options' => array(
					'subscription_period' => self::prepare_filters('Subscription Period'),
					'subscription_period_interval' => self::prepare_filters('Subscription Period Length'),
					'subscription_amount' => self::prepare_filters('Subscription Amount'),
					'installment_months' => self::prepare_filters('Installment Months'),
					'installment_amount' => self::prepare_filters('Installment Amount'),
				),
			);
			$filter_attributes[] = $subscription_attributes;
		}

		/**
		 * Unit Price (WooCommerce Germanized)
		 * Get Germanized for WooCommerce plugins unit attributes.
		 *
		 * @link https://wordpress.org/plugins/woocommerce-germanized/
		 */
		if (class_exists('WooCommerce_Germanized')) {
			$wc_unit_price_attributes = array(
				'optionGroup' => esc_html__('Unit Price (WooCommerce Germanized)', 'custom-product-badge-for-woocommerce'),
				'options' => array(
					'wc_germanized_unit_price_measure' => self::prepare_filters('Unit Price Measure'),
					'wc_germanized_unit_price_base_measure' => self::prepare_filters('Unit Price Base Measure'),
					'wc_germanized_gtin' => self::prepare_filters('GTIN'),
					'wc_germanized_mpn' => self::prepare_filters('MPN'),
				),
			);

			$filter_attributes[] = $wc_unit_price_attributes;
		}

		return $filter_attributes;
	}

	/**
	 * Get WooCommerce Attributes.
	 *
	 * @return array
	 */
	private static function get_global_attributes()
	{
		$taxonomies = array();
		$global_attributes = wc_get_attribute_taxonomy_labels();

		if (count($global_attributes)) {
			foreach ($global_attributes as $key => $value) {
				$taxonomies[sprintf('global_attribute_pa_%s', $key)] = self::prepare_filters(
					$value,
					'select',
					array(
						'type' => 'select',
						'option_type' => 'manual',
						'multiple' => true,
						'options' => get_terms(
							array(
								'taxonomy' => 'pa_' . $key,
								'fields' => 'id=>name',
							)
						),
					)
				);
			}
		}

		return array(
			'optionGroup' => esc_html__('Product Attributes', 'custom-product-badge-for-woocommerce'),
			'options' => $taxonomies,
		);
	}

	/**
	 * Get Product Meta Key Attributes
	 *
	 * @return array
	 */
	private static function get_custom_attributes()
	{
		// Get Variation Attributes
		$attributes = self::query_variations_attributes();
		// Get Product Custom Attributes
		$attributes += self::query_custom_attributes();

		if (empty($attributes)) {
			return array();
		}

		return array(
			'optionGroup' => esc_html__('Product Custom Attributes', 'custom-product-badge-for-woocommerce'),
			'options' => $attributes,
		);
	}

	/**
	 * Get Variation Attributes
	 * Local attributes will be found on variation product meta only with attribute_ suffix
	 *
	 * @return array
	 */
	private static function query_variations_attributes()
	{
		// Get Variation Attributes
		global $wpdb;
		$attributes = array();
		$sql = "SELECT DISTINCT( meta_key ) FROM $wpdb->postmeta
			WHERE post_id IN (
			    SELECT ID FROM $wpdb->posts WHERE post_type = 'product_variation' -- local attributes will be found on variation product meta only with attribute_ suffix
			) AND (
			    meta_key LIKE 'attribute_%' -- include only product attributes from meta list
			    AND meta_key NOT LIKE 'attribute_pa_%'
			)";
		// sanitization ok
		$local_attributes = $wpdb->get_col($sql); // phpcs:ignore

		foreach ($local_attributes as $local_attribute) {
			$local_attribute_label = ucwords(str_replace('-', ' ', $local_attribute));
			$attributes['custom_attribute_' . $local_attribute] = self::prepare_filters($local_attribute_label);
		}

		return $attributes;
	}

	/**
	 * Get Product Custom Attributes
	 * Global attributes will be found on product meta only with attribute_pa_ suffix
	 *
	 * @return array
	 */
	private static function query_custom_attributes()
	{// phpcs:ignore
		global $wpdb;
		$attributes = array();
		$sql = 'SELECT meta.meta_id, meta.meta_key as name, meta.meta_value as type FROM ' . $wpdb->postmeta . ' AS meta, ' . $wpdb->posts . " AS posts WHERE meta.post_id = posts.id AND posts.post_type LIKE '%product%' AND meta.meta_key='_product_attributes';";
		$custom_attributes = $wpdb->get_results($sql); // phpcs:ignore

		if (!empty($custom_attributes)) {
			foreach ($custom_attributes as $value) {
				$product_attr = maybe_unserialize($value->type);

				if (!is_array($product_attr)) {
					continue;
				}

				foreach ($product_attr as $key => $arr_value) {
					if (strpos($key, 'pa_') !== false) {
						continue;
					}

					$attr_label = ucwords(str_replace('-', ' ', $arr_value['name']));
					$attributes['custom_attribute_' . $key] = self::prepare_filters($attr_label);
				}
			}
		}

		return $attributes;
	}

	/**
	 * Get All Taxonomy
	 *
	 * @return array
	 */
	private static function get_all_taxonomy()
	{// phpcs:ignore

		$info = array();
		global $wp_taxonomies;
		$default_excludes = array(
			'product_type',
			'product_visibility',
			'product_cat',
			'product_tag',
			'product_shipping_class',
			'translation_priority',
		);

		/**
		 * Exclude Taxonomy from dropdown
		 *
		 * @param array $user_excludes
		 * @param array $default_excludes
		 */
		$user_excludes = apply_filters('store_manager_dropdown_exclude_taxonomy', array(), $default_excludes);

		if (!empty($user_excludes)) {
			$default_excludes = array_merge($default_excludes, $user_excludes);
		}

		foreach (get_object_taxonomies('product') as $value) {
			if (!empty($value)) {
				$value = trim($value);
			}

			if (in_array($value, $default_excludes, true) || strpos($value, 'pa_') !== false) {
				continue;
			}

			$label = $value;

			if (isset($wp_taxonomies[$value])) {
				$label = $wp_taxonomies[$value]->label . " [$value]";
			}

			$info['product_taxonomy_' . $value] = self::prepare_filters($label);
		}

		if (empty($info)) {
			return array();
		}

		return array(
			'optionGroup' => esc_html__('Product Taxonomies', 'custom-product-badge-for-woocommerce'),
			'options' => $info,
		);
	}

}

<?php

namespace CPBW\App;
use CPBW\App\Utilities\BadgeHelper;

class Badge {

    /**
     * Check if the product passes the filter conditions for applying a badge.
     *
     * This function checks the product against the filter conditions defined in the badge configuration.
     * If the filter is 'all', the product passes. If it's a numeric value, further filtering logic can be applied.
     * If it's an array, the function checks if the product ID matches any of the filter criteria.
     *
     * @param \WC_Product $product      The WooCommerce product object.
     * @param array       $badge_config The configuration array for the badge, including the 'filter' field.
     *
     * @return bool True if the product passes the filter conditions, false otherwise.
     */ 
    public function apply_product_badges( $badge, $product ) {
        if ( $product instanceof \WC_Product ) {
            // Get badge by status (only active badges)
            $active_badges = BadgeHelper::get_badges_for_apply(1);
    
            foreach ( $active_badges as $badge_config ) {
                // Check if the product passes the badge's filter conditions
                if ( ! self::is_product_passed( $product, $badge_config ) ) {
                    continue;
                }
    
                // Check if the badge is valid for the current date
                if ( ! self::is_in_valid_date( $badge_config ) ) {
                    continue;
                }
    
                // Apply the badge style and stop further processing (only one badge applied)
                return self::apply_badge_style( $badge, $badge_config, $product );
            }
    
            // If no badge is applied, return false
            return false;
        }
    }

    /**
     * Apply badge style as an overlay on the product image.
     *
     * This function adds a styled badge overlay on top of the product image using the badge configuration.
     *
     * @param string $badge        The original product image HTML.
     * @param array  $badge_config The configuration array for the badge, including the 'badge_style' field.
     *
     * @return string The product image HTML with the badge overlay applied.
     */ 
    public static function apply_badge_style( $badge, $badge_config, $product = '' ) {

        $is_pro = is_plugin_active( 'store-manager-for-woocommerce-pro/store-manager-for-woocommerce-pro.php' );
    
        $badge_style = $badge_config['badge_style'];
    
        $dynamic_badge = [
            '{{discount_percentage}}', 
            '{{discount_value}}', 
            '{{regular_price}}', 
            '{{sale_price}}'
        ];
    
        // Create a regex pattern that matches any of the dynamic placeholders
        $badge_pattern = '/(' . implode('|', array_map('preg_quote', $dynamic_badge)) . ')/';
    
        $is_dynamic_badge = preg_match( $badge_pattern, $badge_style );

        if( $is_pro && $is_dynamic_badge ) {
            $badge_style = apply_filters( 'store_manager_pro_badge', $badge, $badge_config, $product );
        }
    
        // Wrap the original image with a div and append the badge overlay
        $new_image = $badge . $badge_style;
    
        return $new_image;
    }
    

   /**
     * Check if the product passes the filter conditions for applying a badge.
     *
     * This function checks the product against the filter conditions defined in the badge configuration.
     * If the filter is 'all', the product passes. If it's a numeric value, further filtering logic can be applied.
     * If it's an array, the function checks if the product ID matches any of the filter criteria.
     *
     * @param \WC_Product $product      The WooCommerce product object.
     * @param array       $badge_config The configuration array for the badge, including the 'filter' field.
     *
     * @return bool True if the product passes the filter conditions, false otherwise.
     */
    public static function is_product_passed( $product, $badge_config ){

        $filter = maybe_unserialize($badge_config['filter']);

        if( $filter == 'all' ) {
            return true;
        }

        if( is_numeric( $filter ) ) {
            //@todo: do filter action.
        }

        if ( is_array( $filter ) ) {
            foreach ( $filter as $filter_product ) {
                if ( is_array( $filter_product ) && ( $product->get_id() == $filter_product['id'] ) ) {
                    return true;
                }
            }
        }
    }

    /**
     * Check if the current date is within the valid date range for a badge.
     *
     * This function checks the `valid_from` and `valid_to` dates in the badge configuration 
     * to determine if the badge is valid for the current date. If no date range is specified, 
     * the badge is considered valid by default.
     *
     * @param array $badge_config An associative array containing badge configuration, 
     *                            which may include 'valid_from' and 'valid_to' dates.
     *
     * @return bool True if the current date is within the valid range, or if no valid date 
     *              range is specified. False if the current date is outside the valid range.
     */
    public static function is_in_valid_date( $badge_config ) {
        if( empty( $badge_config['valid_from'] ) ){
            $badge_config['valid_from'] = gmdate( 'Y-m-d H:i:s' );
        }

        if ( empty( $badge_config['valid_from'] ) && empty( $badge_config['valid_to'] ) ) {            
            return true;
        }

        if ( (isset( $badge_config['valid_from'] ) && strtotime( $badge_config['valid_from'] )) && empty( $badge_config['valid_to'] ) ) {
            $today      = gmdate( 'Y-m-d H:i:s' );
            $start_date = gmdate( 'Y-m-d H:i:s', strtotime( $badge_config['valid_from'] ) );

            return ( $today >= $start_date ) ;
        }

        if ( isset( $badge_config['valid_from'], $badge_config['valid_to'] )
            && strtotime( $badge_config['valid_from'] )
            && strtotime( $badge_config['valid_to'] )
        ) {
            $today      = gmdate( 'Y-m-d H:i:s' );
            $start_date = gmdate( 'Y-m-d H:i:s', strtotime( $badge_config['valid_from'] ) );
            $end_date   = gmdate( 'Y-m-d H:i:s', strtotime( $badge_config['valid_to'] ) );

            return ( $today >= $start_date ) && ( $today <= $end_date );
        }

        return false;
    }

}
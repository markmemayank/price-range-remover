<?php
/**
 * Plugin Name: Variable Product Lowest Price
 * Description: Show the lowest price for variable products and update the price based on the selected variation.
 * Version: 1.0
 * Author: Your Name
 * Text Domain: variable-product-lowest-price
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Variable_Product_Lowest_Price {
    
    public function __construct() {
        add_filter('woocommerce_get_price_html', array($this, 'custom_variable_product_price'), 10, 2);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_price_script'));
    }

    public function custom_variable_product_price($price, $product) {
        if ($product->is_type('variable')) {
            $available_variations = $product->get_available_variations();
            $prices = array();

            foreach ($available_variations as $variation) {
                $variation_obj = new WC_Product_Variation($variation['variation_id']);
                $prices[] = $variation_obj->get_price();
            }

            if (!empty($prices)) {
                $min_price = min($prices);
                $price_html = wc_price($min_price);
                $price = '<span class="price" data-default-price="' . esc_attr($price_html) . '">' . $price_html . '</span>';
            }
        }

        return $price;
    }

    public function enqueue_custom_price_script() {
        if (is_product()) {
            wp_enqueue_script('custom-price', plugin_dir_url(__FILE__) . 'custom-price.js', array('jquery'), null, true);
        }
    }
}

new Variable_Product_Lowest_Price();

?>

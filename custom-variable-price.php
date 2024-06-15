<?php
/*
Plugin Name: Custom Variable Price
Description: Show the lowest price for variable products and update the price dynamically when a variation is selected.
Version: 1.0
Author: Mayank Kumar
*/

// Show the lowest price for variable products
add_filter( 'woocommerce_variable_sale_price_html', 'custom_woocommerce_variable_price', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'custom_woocommerce_variable_price', 10, 2 );

function custom_woocommerce_variable_price( $price, $product ) {
    $min_price = $product->get_variation_price( 'min', true );
    $min_price_sale = $product->get_variation_sale_price( 'min', true );

    if ( $min_price_sale < $min_price ) {
        $price = wc_price( $min_price_sale );
    } else {
        $price = wc_price( $min_price );
    }

    $price .= $product->get_price_suffix();

    return $price;
}

// Enqueue the custom JavaScript
function custom_enqueue_scripts() {
    if ( is_product() ) {
        wp_enqueue_script( 'custom-variation-price', plugin_dir_url( __FILE__ ) . 'js/custom-variation-price.js', array( 'jquery' ), '1.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' );

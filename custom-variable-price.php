function wc_custom_variable_product_price($price, $product) {
    if ($product->is_type('variable')) {
        $available_variations = $product->get_available_variations();
        $prices = array();

        foreach ($available_variations as $variation) {
            $variation_obj = new WC_Product_Variation($variation['variation_id']);
            $prices[] = $variation_obj->get_price();
        }

        if (!empty($prices)) {
            $min_price = min($prices);
            $price = wc_price($min_price);
        }
    }

    return $price;
}
add_filter('woocommerce_get_price_html', 'wc_custom_variable_product_price', 10, 2);

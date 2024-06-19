function enqueue_custom_price_script() {
    if (is_product()) {
        wp_enqueue_script('custom-price', get_stylesheet_directory_uri() . '/custom-price.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_price_script');

function add_default_price_data_attribute($price, $product) {
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
            $price .= '<span class="price" data-default-price="' . esc_attr($price_html) . '">' . $price_html . '</span>';
        }
    }

    return $price;
}
add_filter('woocommerce_get_price_html', 'add_default_price_data_attribute', 10, 2);

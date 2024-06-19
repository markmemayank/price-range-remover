jQuery(document).ready(function($) {
    // Update the price when a variation is selected
    $('form.variations_form').on('show_variation', function(event, variation) {
        if (variation && variation.display_price !== undefined) {
            var price_html = variation.price_html;
            $('.woocommerce-variation-price .price').html(price_html);
        }
    });

    // Reset to the lowest price if no variation is selected
    $('form.variations_form').on('hide_variation', function() {
        var default_price = $('form.variations_form').find('.single_variation_wrap .woocommerce-variation-price .price').data('default-price');
        if (default_price) {
            $('.woocommerce-variation-price .price').html(default_price);
        }
    });
});

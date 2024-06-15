jQuery(document).ready(function($) {
    // Update the price when a variation is selected
    $('form.variations_form').on('found_variation', function(event, variation) {
        if (variation.price_html !== undefined) {
            // Update the main price HTML
            $('.summary .price').html(variation.price_html);
        }
    });

    // Reset the price when no variation is selected
    $('form.variations_form').on('reset_data', function() {
        var $price = $(this).find('.summary .price');
        var original_price = $price.data('original-price');
        if (original_price) {
            $price.html(original_price);
        }
    });
});

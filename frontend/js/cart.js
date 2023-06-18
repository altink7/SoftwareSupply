var cart = {
    addToCart: function(productId) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php',
            data: JSON.stringify({
                request_type: 'add_to_cart',
                product_id: productId
            }),
            contentType: 'application/json', // Set the content type to JSON
            success: function(response) {
                if (response.status === 'success') {
                    cart.updateCartCount(response.cart_count);
                    alert('Product added to cart successfully!');
                } else {
                    alert('Failed to add product to cart. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + error);
            }
        });
    },
    updateCartCount: function(count) {
        $('.shopping-cart-button .cart-count').text(count);
    }
};

$(document).ready(function() {
    var addToCartButtons = $('.add-to-cart-button');

    addToCartButtons.on('click', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        cart.addToCart(productId);
    });
});

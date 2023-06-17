var cart = {
    addToCart: function(productId) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php',
            data: {
                request_type: 'add_to_cart',
                product_id: productId
            },
            success: function(response) {
                if (response.status === 'success') {
                    updateCartCount(response.cart_count);
                    alert('Product added to cart successfully!');
                } else {
                    alert('Failed to add product to cart. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + error);
            }
        });
    }
};

$(document).ready(function() {
    var addToCartButtons = $('.add-to-cart-button');
    var shoppingCartButton = $('.shopping-cart-button');

    addToCartButtons.on('click', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        cart.addToCart(productId);
    });

    function updateCartCount(count) {
        shoppingCartButton.find('.cart-count').text(count);
    }
});

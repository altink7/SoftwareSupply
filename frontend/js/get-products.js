$(document).ready(function() {
    var categoryDropdown = $('.category-dropdown');
    var apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=products';

    categoryDropdown.on('change', function() {
        var selectedCategory = $(this).val();

        if (selectedCategory !== 'none') {
            apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=productsByCategory&kategorie=' + selectedCategory;
        } else {
            apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=products';
        }

        fetchProducts(apiUrl);
    });

    function fetchProducts(apiUrl) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            contentType: 'application/json',
            url: apiUrl,
            success: function(response) {
                if (response.length > 0) { // Check if there is any data in the response
                    var productList = $('#productList');
                    productList.empty(); // Clear existing products before appending new ones

                    response.forEach(function(product) {
                        var card = $('<div class="card"></div>');
                        var cardInner = $('<div class="card-inner"></div>');
                        var cardBody = $('<div class="card-body"></div>');
                        var cardTitle = $('<h2 class="card-title"></h2>');
                        var cardText = $('<p></p>');
                        var cardFooter = $('<div class="card-footer"></div>');
                        var cardButton = $('<button class="btn btn-primary">Add to cart</button>');

                        cardTitle.text(product.title);
                        cardText.text(product.description);
                        cardFooter.text('Price: $' + product.price+' |  Review:'+ product.review);
                        cardBody.append(cardTitle);
                        cardBody.append(cardText);
                        cardBody.append(cardButton);
                        cardInner.append(cardBody);
                        cardInner.append(cardFooter);
                        card.append(cardInner);
                        productList.append(card);

                        cardButton.on('click', function() {
                            var productId = product.id;
                            cart.addToCart(productId);
                        });
                    });
                } else {
                    console.error('Error: No data found.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + error);
            }
        });
    }

    fetchProducts(apiUrl);
});

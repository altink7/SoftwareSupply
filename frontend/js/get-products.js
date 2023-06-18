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

                response.forEach(function(product, index) {
                    var imagePath = 'http://localhost/SoftwareSupply/backend/productpictures/' + product.image_url + '.png';
                    var cardCol = $('<div class="col-md-3 d-flex"></div>'); 
                    var card = $('<div class="card mb-4"></div>');
                    var cardImage = $('<img class="card-img-top small-icon" src="' +imagePath + '" alt="software">'); 
                    var cardBody = $('<div class="card-body"></div>');
                    var cardTitle = $('<h5 class="card-title">' + product.title + '</h5>');
                    var cardText = $('<p class="card-text">' + product.description + '</p>');
                    var cardFooter = $('<div class="card-footer"></div>');
                    var priceReview = $('<p class="price-review">Price: €' + product.price + ' | Review: ' + product.review + '</p>');
                    var cardButton = $('<button class="btn btn-primary card-button">Add to Cart</button>');

                    cardBody.append(cardTitle);
                    cardBody.append(cardText);
                    cardFooter.append(priceReview);
                    cardFooter.append(cardButton);
                    card.append(cardImage);
                    card.append(cardBody);
                    card.append(cardFooter);
                    cardCol.append(card);

                    if (index % 4 === 0) {
                        var row = $('<div class="row"></div>'); // Create a new row for every fourth card
                        $('#productList').append(row);
                    }
                
                    $('#productList .row:last-child').append(cardCol); // Append the card to the last row

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

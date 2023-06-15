$(document).ready(function() {
    $.ajax({
        type: 'GET',
        dataType: 'json',
        contentType: 'application/json',
        url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=products',
        success: function(response) {
            if (response.length > 0) {  // Check if there is any data in the response
                var productList = $('#productList');
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
                    cardFooter.text('Price: $' + product.price);
                    cardBody.append(cardTitle);
                    cardBody.append(cardText);
                    cardBody.append(cardButton);
                    cardInner.append(cardBody);
                    cardInner.append(cardFooter);
                    card.append(cardInner);
                    productList.append(card);
                });
            } else {
                console.error('Error: No data found.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + error);
        }
    });
});

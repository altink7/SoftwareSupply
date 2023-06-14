$(document).ready(function() {
    // Make an AJAX GET request to retrieve products data from the API
    $.ajax({
        url: 'http://localhost/SoftwareSupply/backend/api/api.php',
        type: 'GET',
    success: function(response) {
        if (response.status === 'success') {
            console.log(response.data);
        // Iterate over the products and create a card for each product
            var productList = $('#productList');
            response.data.forEach(function(product) {
            var card = $('<div>', { class: 'col' });
            var cardInner = $('<div>', { class: 'card h-100 product-card' });
            //var cardImg = $('<img>', { class: 'card-img-top', src: product.image, alt: 'Product Image' });
            var cardBody = $('<div>', { class: 'card-body' });
            var cardTitle = $('<h5>', { class: 'card-title', text: product.title });
            var cardText = $('<p>', { class: 'card-text', text: product.description });
            var cardFooter = $('<div>', { class: 'card-footer' });
            var cardButton = $('<a>', { href: 'productDetail.html', class: 'btn btn-primary card-button', text: 'Shop' });
      
            cardBody.append(cardTitle, cardText);
            cardFooter.append(cardButton);
            cardInner.append(cardImg, cardBody, cardFooter);
            card.append(cardInner);
            productList.append(card);
            });
        } else {
            console.error('Error: ' + response.message);
        }
    },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + error);
        }
    });
});
      
  
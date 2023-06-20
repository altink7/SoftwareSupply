$(document).ready(function () {
  var categoryDropdown = $('.category-dropdown');
  var apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=products';

  categoryDropdown.on('change', function () {
    var selectedCategory = $(this).val();
    var searchQuery = $('.search-input').val();

    if (selectedCategory !== 'none') {
      apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=productsByCategory&kategorie=' + selectedCategory;
    } else {
      apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=products';
    }

    if (searchQuery !== '') {
      apiUrl += '&search=' + searchQuery;
    }

    fetchProducts(apiUrl);
  });

  $('.search-input').on('input', function () {
    var selectedCategory = $('.category-dropdown').val();
    var searchQuery = $(this).val();
    apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=products';

    if (selectedCategory !== 'none') {
      apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=productsByCategory&kategorie=' + selectedCategory;
    }

    if (searchQuery !== '') {
      apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=productsBySearch&search=' + searchQuery;
    }

    fetchProducts(apiUrl);
  });

  function fetchProducts(apiUrl) {
    $.ajax({
      type: 'GET',
      dataType: 'json',
      contentType: 'application/json',
      url: apiUrl,
      success: function (response) {
        if (response.length > 0) {
          var productList = $('#productList');
          productList.empty();

          response.forEach(function (product, index) {
            var imagePath = 'http://localhost/SoftwareSupply/backend/productpictures/' + product.image_url + '.png';
            var cardCol = $('<div class="col-md-3 d-flex"></div>');
            var card = $('<div class="card mb-4 draggable"></div>');
            var cardImage = $('<img class="card-img-top small-icon" src="' + imagePath + '" alt="software">');
            var cardBody = $('<div class="card-body"></div>');
            var cardTitle = $('<h5 class="card-title">' + product.title + '</h5>');
            var cardText = $('<p class="card-text description">' + product.description + '</p>');
            var cardFooter = $('<div class="card-footer"></div>');
            var priceReview = $('<p class="price-review">Price: €' + product.price + ' | ' + product.review + '/5 &star;</p>');
            var cardButton = $('<button class="btn btn-primary card-button add-to-cart-button" data-product-id="' + product.id + '"><i class="fas fa-shopping-cart"></i></button>');


            cardBody.append(cardTitle);
            cardBody.append(cardText);
            cardFooter.append(priceReview);
            cardFooter.append(cardButton);
            card.append(cardImage);
            card.append(cardBody);
            card.append(cardFooter);
            cardCol.append(card);


            card.draggable({
              revert: 'invalid',
              helper: 'clone',
              start: function (event, ui) {
                ui.helper.css('width', card.width());
              }
            });

            cardButton.on('click', function () {
              var productId = product.id;
              cart.addToCart(productId);
            });

            var maxDescriptionLength = 100;
            if (product.description.length > maxDescriptionLength) {
              var truncatedDescription = product.description.substring(0, maxDescriptionLength) + '...';
              cardText.text(truncatedDescription);
            }


            cardBody.addClass('d-flex flex-column justify-content-between');


            if (index % 4 === 0) {
              var row = $('<div class="row"></div>');
              $('#productList').append(row);
            }

            $('#productList .row:last-child').append(cardCol);

            cardButton.on('click', function () {
              var productId = product.id;
              cart.addToCart(productId);
            });

            card.draggable({ // Make the card draggable
              revert: 'invalid',
              helper: 'clone',
              start: function (event, ui) {
                ui.helper.css('width', card.width());
                ui.helper.data('product-id', product.id); // Set the product ID as data attribute
              }
            });

            card.append(cardImage);
            card.append(cardBody);
            card.append(cardFooter);
            cardCol.append(card);
          });
        } else {
          console.error('Error: No data found.');
        }
      },
      error: function (xhr, status, error) {
        console.error('AJAX Error: ' + error);
      }
    });
  }

  fetchProducts(apiUrl);

  // Make shopping cart icon droppable
  $('.shopping-cart-button').droppable({
    accept: '.draggable',
    drop: function (event, ui) {
      var productId = ui.helper.data('product-id');
      cart.addToCart(productId);
    }
  });
});

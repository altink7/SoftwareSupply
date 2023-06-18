$(document).ready(function() {
    var categoryDropdown = $('.category-dropdown');
    var apiUrl = 'http://localhost/SoftwareSupply/backend/api/api.php?type=products';
  
    categoryDropdown.on('change', function() {
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
  
    $('.search-input').on('input', function() {
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
        success: function(response) {
          if (response.length > 0) {
            var productList = $('#productList');
            productList.empty();
  
            response.forEach(function(product, index) {
              var imagePath = 'http://localhost/SoftwareSupply/backend/productpictures/' + product.image_url + '.png';
              var cardCol = $('<div class="col-md-3 d-flex"></div>');
              var card = $('<div class="card mb-4"></div>');
              var cardImage = $('<img class="card-img-top small-icon" src="' + imagePath + '" alt="software">');
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
                var row = $('<div class="row"></div>');
                $('#productList').append(row);
              }
  
              $('#productList .row:last-child').append(cardCol);
  
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
  
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
            alert('Produkt erfolgreich zum Warenkorb hinzugefügt!');
          } else {
            alert('Fehler beim Hinzufügen des Produkts zum Warenkorb. Bitte versuchen Sie es erneut.');
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

    // Make product items draggable
    $('.draggable').draggable({
      revert: 'invalid',
      helper: 'clone',
      start: function(event, ui) {
        // Set a fixed width for the dragged product item
        ui.helper.css('width', $(this).width());
      }
    });

    // Make shopping cart icon droppable
    $('.shopping-cart-button').droppable({
      accept: '.draggable',
      drop: function(event, ui) {
        var productId = ui.helper.data('product-id');
        cart.addToCart(productId);
      }
    });

    // Make drop area droppable
    $('.drop-area').droppable({
      accept: '.draggable',
      drop: function(event, ui) {
        var productId = ui.helper.data('product-id');
        cart.addToCart(productId);
      }
    }).on('dragover', function(event) {
      event.preventDefault(); // Prevent the default dragover behavior
    });

    addToCartButtons.on('click', function(e) {
      e.preventDefault();
      var productId = $(this).data('product-id');
      cart.addToCart(productId);
    });
  });
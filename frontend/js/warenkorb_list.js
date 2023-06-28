$(document).ready(function() {
    var cartTable = $('#cart-table').find('tbody');

    function addRowToCartTable(item) {
      var price = parseFloat(item.price).toFixed(2);
      var total = (price * item.quantity).toFixed(2);

      var row = $('<tr></tr>');
      row.append($('<td></td>').text(item.title));
      row.append($('<td></td>').text(price + ' €'));

      var quantitySelect = $('<select class="quantity-select"></select>');
      for (var i = 1; i <= 10; i++) {
        var option = $('<option></option>').attr('value', i).text(i);
        if (i === item.quantity) {
          option.attr('selected', 'selected');
        }
        quantitySelect.append(option);
      }
      row.append($('<td></td>').append(quantitySelect));

      row.append($('<td></td>').text(total + ' €'));

      var removeButton = $('<button class="btn btn-primary card-button">Entfernen</button>');
      removeButton.attr('data-product-id', item.id); // Set the product ID in the button's data attribute
      row.append($('<td></td>').html(removeButton));

      cartTable.append(row);

      // Update the total
      cartTotal = calculateTotalPrice();
      $('#cart-total-sum').text(cartTotal.toFixed(2) + ' €');
    }

    // Remove button click event
    cartTable.on('click', '.card-button', function() {
      var productId = $(this).data('product-id');
      removeProduct(productId);
    });

    // Quantity select change event
    cartTable.on('change', '.quantity-select', function() {
      var row = $(this).closest('tr');
      var quantity = parseInt($(this).val(), 10);
      var price = parseFloat(row.find('td:eq(1)').text());
      var total = (price * quantity).toFixed(2);
      row.find('td:eq(3)').text(total + ' €');

      // Update the total
      cartTotal = calculateTotalPrice();
      $('#cart-total-sum').text(cartTotal.toFixed(2) + ' €');
      // Retrieve the selected quantity from the option
      var quantity = parseInt($(this).val(), 10);

      // Pass the selected quantity to the API
      var productId = row.find('.card-button').data('product-id');
      updateProductQuantity(productId, quantity);
    });

  // Function to update the quantity of a product
  function updateProductQuantity(productId, quantity) {
    var data = {
      product_id: productId,
      quantity: quantity,
      request_type: 'update_quantity'
    };

    $.ajax({
      type: 'POST',
      url: 'http://localhost/SoftwareSupply/backend/api/api.php',
      data: JSON.stringify(data),
      contentType: 'application/json',
      success: function(response) {
        if (response.status === 'success') {
          console.log('Product quantity updated successfully.');
          console.log(response.cart_count);

          // Update the total
          cartTotal = calculateTotalPrice();
          $('#cart-total-sum').text(cartTotal.toFixed(2) + ' €');
          console.log(cartTotal + ' €' + ' updated');
        } else {
          console.log(response.status)
          console.log('Failed to update product quantity.');
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error: ' + error);
      }
    });
  }

    // Function to remove a product
    function removeProduct(productId) {
      var data = {
        product_id: productId,
        request_type: 'removeProduct'
      };

      $.ajax({
        type: 'POST',
        url: 'http://localhost/SoftwareSupply/backend/api/api.php',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
          if (response.status === 'success') {
            // Remove the row from the table
            var row = $('button[data-product-id="' + productId + '"]').closest('tr');
            row.remove();

            console.log('Product removed successfully.');
            console.log(response.card_count);

            // Update the total
            cartTotal = calculateTotalPrice();
            $('#cart-total-sum').text(cartTotal.toFixed(2) + ' €');

          } else {
            console.log('Failed to remove product.');
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error: ' + error);
        }
      });
    }

    // AJAX call to retrieve cart data
    $.ajax({
      type: 'GET',
      url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=cart',
      success: function(response) {
        if (response) {
          response.forEach(function(item) {
            addRowToCartTable(item);
          });
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error: ' + error);
      }
    });

    function calculateTotalPrice() {
      var totalPrice = 0;

      $('#cart-table tbody tr').each(function() {
        var totalText = $(this).find('td:eq(3)').text().trim();
        var totalValue = parseFloat(totalText);

        if (!isNaN(totalValue)) {
          totalPrice += totalValue;
        }
      });

      console.log(totalPrice);
      return totalPrice;
    }
  });

$(document).ready(function() {
    var cartTable = $('#cart-table').find('tbody');

    function addRowToCartTable(item) {
        var price = parseFloat(item.price).toFixed(2);
        var total = (price * item.quantity).toFixed(2);

        var row = $('<tr></tr>');
        row.append($('<td></td>').text(item.title));
        row.append($('<td></td>').text(price + ' €'));
        row.append($('<td></td>').text(item.quantity)); // Display the selected quantity

        row.append($('<td></td>').text(total + ' €'));

        cartTable.append(row);

        // Update the total
        cartTotal = calculateTotalPrice();
        $('#cart-total-sum').text(cartTotal.toFixed(2) + ' €');
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

    function saveOrder() {
        // AJAX call to save the order
        $.ajax({
            type: 'POST',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php',
            data: {
                total_price: cartTotal,
                request_type: 'save_order'
            },
            success: function(response) {
                if (response.status === 'success') {
                    var orderId = response.order_id;
                    // Get the cart positions
                    var positions = [];
                    $('#cart-table tbody tr').each(function() {
                        var productId = $(this).data('product-id');
                        var quantity = parseInt($(this).find('td:eq(2)').text());
                        positions.push({ product_id: productId, quantity: quantity });
                    });
                    // Save order positions
                    saveOrderPositions(orderId, positions);
                } else {
                    console.error('Error saving order.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + error);
            }
        });
    }

    function saveOrderPositions(orderId, positions) {
        // Array to hold the final order positions
        var orderPositions = [];

        // Iterate over the positions and retrieve the price from the products table
        positions.forEach(function(position) {
            var productId = position.product_id;
            var quantity = position.quantity;

            // AJAX call to retrieve the price from the products table
            $.ajax({
                type: 'GET',
                url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=product&id=' + productId,
                success: function(response) {
                    if (response) {
                        var price = response.price;

                        // Calculate the total position price
                        var totalPositionPrice = parseFloat(price) * parseInt(quantity);

                        // Create the order position object
                        var orderPosition = {
                            order_id: orderId,
                            product_id: productId,
                            price: price,
                            quantity: quantity,
                            total_position_price: totalPositionPrice
                        };

                        // Add the order position to the array
                        orderPositions.push(orderPosition);

                        // Check if all positions have been processed
                        if (orderPositions.length === positions.length) {
                            // AJAX call to save order positions
                            $.ajax({
                                type: 'POST',
                                url: 'http://localhost/SoftwareSupply/backend/api/api.php',
                                data: {
                                    request_type: 'save_order_positions',
                                    order_id: orderId,
                                    positions: orderPositions
                                },
                                success: function(response) {
                                    if (response.status === 'success') {
                                        console.log('Order positions saved successfully.');
                                        // Redirect to the order confirmation page or perform any other necessary actions
                                    } else {
                                        console.error('Error saving order positions.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('AJAX Error: ' + error);
                                }
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                }
            });
        });
    }


    $('.card-button').click(function() {
        saveOrder();
    });
});

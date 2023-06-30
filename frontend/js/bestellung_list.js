$(document).ready(function() {
    var cartTable = $('#cart-table').find('tbody');
    var cartData = []; // Store cart data globally

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
                cartData = response; // Store cart data globally
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

        return totalPrice;
    }

    function saveOrder() {
        // AJAX call to save the order
        $.ajax({
            type: 'POST',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php',
            data: JSON.stringify({
                total_price: cartTotal,
                request_type: 'save_order'
            }),
            success: function(response) {
                if (response.status === 'success') {
                    var orderId = response.order_id;
                    // Get the cart positions
                    var positions = [];
                    $('#cart-table tbody tr').each(function() {
                        var quantity = parseInt($(this).find('td:eq(2)').text());
                        positions.push({ quantity: quantity });
                    });

                    saveOrderPositions(orderId, positions);
                } else {
                    console.error('Error saving order.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    }

    function saveOrderPositions(orderId, positions) {
        var orderPositions = [];

        positions.forEach(function(position, index) {
            var quantity = position.quantity;
            var title = cartData[index].title;

            var orderPosition = {
                order_id: orderId,
                title: title,
                quantity: quantity
            };

            orderPositions.push(orderPosition);
        });
        console.log(orderPositions);
        $.ajax({
            type: 'POST',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php',
            data: JSON.stringify({
                request_type: 'save_order_positions',
                order_id: orderId,
                positions: orderPositions
            }),
            success: function(response) {
                if (response.status === 'success') {
                    console.log('Order positions saved successfully.');
                } else {
                    console.error('Error saving order positions.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    }


    $('.card-button').click(function() {
        saveOrder();
    });
});

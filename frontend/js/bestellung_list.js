$(document).ready(function () {
    var cartTable = $('#cart-table').find('tbody');
    var cartData = []; // Store cart data globally
    var discountApplied = false;


    $('#apply-gift-code').click(function () {
        if (!discountApplied) { // Check if the discount has not been applied yet
            var cartTotal = calculateTotalPrice();
            var newTotal = cartTotal;

            // Create a new element for the discounted price
            var discountText = $('<span></span>').text(newTotal.toFixed(2) + ' €');
            var discountElement = $('<p></p>').text('Neuer Preis: ').append(discountText);

            // Append the discounted price element next to the total price
            $('#cart-total-sum').after(discountElement);

            // Set the discountApplied flag to true
            discountApplied = true;
        }
    });


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
        success: function (response) {
            if (response) {
                cartData = response; // Store cart data globally
                response.forEach(function (item) {
                    addRowToCartTable(item);
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error: ' + error);
        }
    });

    function calculateTotalPrice() {
        var totalPrice = 0;

        $('#cart-table tbody tr').each(function () {
            var totalText = $(this).find('td:eq(3)').text().trim();
            var totalValue = parseFloat(totalText);

            if (!isNaN(totalValue)) {
                totalPrice += totalValue;
            }
        });

        // Apply gift code reduction
        var giftCode = $('#gift-code-input').val().trim();
        if (giftCode === '10%OFF') {
            totalPrice *= 0.9; // Reduce the total price by 10%
        } else if (giftCode !== '' && giftCode !== '10%OFF') {
            alert('Der eingegebene Gutscheincode ist ungültig.');
        }

        return totalPrice;
    }


    function saveOrder() {
        var paymentMethod = $('#payment-method').val();

        if (paymentMethod === 'none') {
            alert('Please select a payment method.');
            return;
        }

        var cartTotal = calculateTotalPrice();
        var newTotal = cartTotal; // Initialize with the current total price

        if (discountApplied) { // Check if discount is applied
            var discountText = $('#cart-total-sum').next('p').find('span').text();
            newTotal = parseFloat(discountText.replace(' €', ''));
        }

        // AJAX call to save the order
        $.ajax({
            type: 'POST',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php',
            data: JSON.stringify({
                total_price: cartTotal,
                discounted_price: newTotal, // Save the discounted price
                request_type: 'save_order'
            }),
            success: function (response) {
                if (response.status === 'success') {
                    var orderId = response.order_id;
                    // Get the cart positions
                    var positions = [];
                    $('#cart-table tbody tr').each(function () {
                        var quantity = parseInt($(this).find('td:eq(2)').text());
                        positions.push({ quantity: quantity });
                    });

                    saveOrderPositions(orderId, positions);
                } else {
                    console.error('Error saving order.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    }


    function saveOrderPositions(orderId, positions) {
        var orderPositions = [];

        positions.forEach(function (position, index) {
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
            success: function (response) {
                if (response.status === 'success') {
                    console.log('Order positions saved successfully.');

                    // Show success message in a dialog
                    showDialog('Bestellung erfolgreich aufgegeben.');

                    // Delete all items from the cart
                    deleteCartItems();
                } else {
                    console.error('Error saving order positions.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    }

    function showDialog(message) {
        // Show the message in a dialog or alert
        alert(message);
    }

    function deleteCartItems() {
        $.ajax({
            type: 'DELETE',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=cart',
            success: function (response) {
                console.log('Cart items deleted successfully.');
                // Clear the cart table
                cartTable.empty();
                // Update the total
                cartTotal = 0;
                $('#cart-total-sum').text('0.00 €');

                //redirect to userProfil
                window.location.href = "http://localhost/SoftwareSupply/frontend/sites/userProfil.html";
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    }

    $('#bestellen').click(function () {
        saveOrder();
    });
});

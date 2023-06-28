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
});

$(document).ready(function() {
    var cartTable = $('#cart-table').find('tbody');
    var cartTotal = 0;

    function addRowToCartTable(item) {
        var price = parseFloat(item.price).toFixed(2);
        var total = (price * item.quantity).toFixed(2);
        cartTotal = (parseFloat(cartTotal) + parseFloat(total)).toFixed(2);
        $('#cart-total').text(cartTotal + ' €');

        var row = $('<tr></tr>');
        row.append($('<td></td>').text(item.title));
        row.append($('<td></td>').text(price + ' €'));
        row.append($('<td></td>').text(item.quantity));
        row.append($('<td></td>').text(total + ' €'));
        row.append($('<td></td>').html('<button class="btn btn-primary card-button">Entfernen</button>'));

        cartTable.append(row);
    }

    // AJAX call to retrieve cart data and populate the table
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=cart',
        success: function(response) {
            if (Array.isArray(response)) {
                var cartItems = response;

                $.each(cartItems, function(index, item) {
                    addRowToCartTable(item);
                });
            } else {
                console.log('Failed to retrieve cart data.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + error);
        }
    });
});

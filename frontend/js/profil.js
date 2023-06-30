$(document).ready(function() {
    $.ajax({
        url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=get_orders_for_user',
        method: 'GET',
        success: function(response) {
            if (Array.isArray(response)) {
                var orders = response;

                var tableBody = $('table tbody');
                tableBody.empty();
                orders.forEach(function(order, index) {
                    var row = $('<tr>');
                    row.append($('<th>').text(index + 1));
                    row.append($('<td>').text(order.id));
                    row.append($('<td>').text(order.created));
                    row.append($('<td>').text(order.updated));
                    row.append($('<td>').text(order.total + ' €'));
                    tableBody.append(row);
                });
            } else {
                console.error('Invalid response:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

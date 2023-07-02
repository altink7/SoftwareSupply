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
                    row.append($('<td>').text((order.total - order.voucher) + ' €'));

                    var invoiceButton = $('<button>').text('Rechnung').addClass('btn btn-primary');
                    invoiceButton.click(function() {
                        //AJAX GET-Request an den PHP-Endpunkt
                        $.ajax({
                            url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=get_invoice&order_id=' + order.id,
                            method: 'GET',
                            success: function(response) {
                                console.log(response);
                                window.open("http://localhost/SoftwareSupply/backend/api/" + response, "_blank");
                            },
                            error: function(xhr, status, error) {
                                alert('In Arbeit, wird gefixt bald, in Backend ist der Fehler');
                                console.error(error);
                            }
                        });

                    });

                    var invoiceCell = $('<td>').append(invoiceButton);
                    row.append(invoiceCell);

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

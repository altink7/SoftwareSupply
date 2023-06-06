$(document).ready(function () {
    $('form').submit(function (event) {
        event.preventDefault();

        var username = $('#username').val();
        var password = $('#password').val();

        var data = {
            username: username,
            password: password,
            request_type: 'login'
        };

        $.ajax({
            type: 'POST',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php', 
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function (response) {
                if (response.status === 'success') {
                    // Login successful, redirect to a desired page
                    window.location.href = 'userProfil.html';
                }
            },
            error: function (xhr, status, error) {
                alert('Invalid username or password. Please try again.');
            }
        });
    });
});

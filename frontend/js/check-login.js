$(document).ready(function () {
    $('form').submit(function (event) {
        event.preventDefault();

        var username = $('#username').val();
        var password = $('#password').val();

        var data = {
            username: username,
            password: password
        };

        $.ajax({
            type: 'POST',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php', // Replace with the actual URL of your login endpoint
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function (response) {
                if (response.status === 'success') {
                    // Login successful, redirect to a desired page
                    window.location.href = 'userProfil.html';
                } else {
                    // Invalid credentials, display an error message
                    alert('Invalid username or password. Please try again.');
                }
            },
            error: function (xhr, status, error) {
                // Handle error case
                alert('An error occurred while processing your request. Please try again later.');
                console.log('AJAX error:', error);
            }
        });
    });
});

$(document).ready(function () {
    // Check if the user is already logged in and update the navbar accordingly
    checkLoginStatus();

    // Add event listener to the Logout link
    $('#logout-link').click(function (event) {
        event.preventDefault();

        // Send AJAX request to logout
        $.ajax({
            type: 'POST',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php',
            data: JSON.stringify({ request_type: 'logout' }),
            contentType: 'application/json',
            success: function (response) {
                if (response.status === 'success') {
                    // Logout successful, redirect to the index page
                    window.location.href = 'index.html';
                }
            },
            error: function (xhr, status, error) {
                alert('Error logging out. Please try again.');
            }
        });
    });

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
                    // Login successful, redirect to the profile page
                    window.location.href = 'userProfil.html';
                }
            },
            error: function (xhr, status, error) {
                alert('Invalid username or password. Please try again.');
            }
        });
    });

    // Function to check if the user is logged in and update the navbar accordingly
    function checkLoginStatus() {
        $.ajax({
            type: 'GET',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=login_status',
            dataType: 'json',
            success: function (response) {
                if (response.logged_in === true) {
                    $('#login-link').text('Profil');
                    $('#login-link').attr('href', 'userProfil.html');
                } else {
                    $('#login-link').text('Login');
                    $('#login-link').attr('href', 'login.html');
                }
            },
            error: function (xhr, status, error) {
                console.log('Error checking login status');
            }
        });
    }

});

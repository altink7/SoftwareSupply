$(document).ready(function () {
    // Check if the user is already logged in and update the navbar accordingly
    checkLoginStatus();

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
                    // Login successful, update the navbar and redirect to the profile page
                    updateNavbar(true);
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
            success: function (response) {
                if (response.logged_in === true) {
                    updateNavbar(true);
                } else {
                    updateNavbar(false);
                }
            },
            error: function (xhr, status, error) {
                console.log('Error checking login status');
            }
        });
    }

    // Function to update the navbar based on the login status
    function updateNavbar(loggedIn) {
        var profileLink = $('#profile-link');
        var loginLink = $('#login-link');

        if (loggedIn) {
            profileLink.text('Profil');
            loginLink.hide();
            profileLink.show();
        } else {
            profileLink.text('Login');
            profileLink.hide();
            loginLink.show();
        }
    }
});

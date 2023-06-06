$(document).ready(function () {

    function checkLogin() {

        var username = $('#username').val();
        var password = $('#password').val();

        $.ajax({
            type: 'POST',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php',
            data: JSON.stringify({ username: username, password: password }),
            contentType: 'application/json',
            success: function (response) {
                if (response.status === 'success') {
                    console.log(response + response.status);
                    alert('Successfully logged in!');
                    setTimeout(function () {
                        window.location.href = "userProfil.html";
                    }, 1000);
                } else {
                    alert('Login failed. Please check your username and password.');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                alert('An error occurred during login. Please try again later.');
            }
        });
    }

$('form').submit(function(event) {
    event.preventDefault();

    checkLogin();
    });
});

  
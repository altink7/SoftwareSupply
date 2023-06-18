$(document).ready(function () {

    // Function to fetch and display user profile data
    function fetchUserProfile() {
        $.ajax({
            type: 'GET',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=login_status',
            dataType: 'json',
            success: function (response) {
                if (response.logged_in) {
                    var userProfile = response.user_profile;
                    var name = userProfile.username;
                    var first_name = userProfile.first_name;
                    var last_name = userProfile.last_name;
                    var email = userProfile.email;
                    var address = userProfile.address;
                    var postal_code = userProfile.postal_code;
                    var city = userProfile.city;
                    var password = userProfile.password;
                    var payment = userProfile.payment;


                    // Update the profile section with the user data
                    $('#username').text(name);
                    $('#first_name').text(first_name);
                    $('#last_name').text(last_name);
                    $('#email').text(email);
                    $('#address').text(address);
                    $('#zip_code').text(postal_code);
                    $('#city').text(city);
                    $('#password').text(password);
                    $('#payment').text(payment);
                }
            },
            error: function (xhr, status, error) {
                console.log('Error fetching user profile data');
            }
        });
    }

    // Call fetchUserProfile function on document ready
    fetchUserProfile();
});
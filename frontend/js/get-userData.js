$(document).ready(function () {
    var isPasswordModified = false; // Flag to track if the password field is modified

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
                    var password = '********';
                    var payment = userProfile.payment;

                    // Update the profile section with the user data
                    $('#username').text(name);
                    $('#first_name').text(first_name);
                    $('#last_name').text(last_name);
                    $('#email').text(email);
                    $('#address').text(address);
                    $('#zip_code').text(postal_code);
                    $('#city').text(city);
                    $('#password').text(password); // Display asterisks instead of the actual password
                    $('#payment').val(payment);

                    $('#password').on('input', function () {
                        isPasswordModified = true; // Set the flag when the password field is modified
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log('Error fetching user profile data');
            }
        });
    }

    // Function to enable editing of user data
    function enableEdit() {
        $('.profile-section span').attr('contenteditable', 'true');
        $('#editButton').hide();
        $('#saveButton').show();
        $('#payment').prop('disabled', false);
    }
    // Function to save the updated user data
    function saveData() {
        var updatedData = {
            first_name: $('#first_name').text(),
            last_name: $('#last_name').text(),
            email: $('#email').text(),
            address: $('#address').text(),
            postal_code: $('#zip_code').text(),
            city: $('#city').text(),
            payment: $('#payment').val()
        };

        // Check if the password field is modified
        if (isPasswordModified) {
            // Validate the updated password
            var newPassword = $('#password').text();
            if (newPassword.length < 8) {
                alert('Das Passwort muss mindestens 8 Zeichen lang sein.');
                return;
            }

            var confirmPassword = prompt('Bitte bestätigen Sie das neue Passwort:');
            if (newPassword !== confirmPassword) {
                alert('Die Passwörter stimmen nicht überein.');
                return;
            }
            updatedData.password = newPassword;
        }

        // Make an AJAX request to save the updated data to the database
        $.ajax({
            type: 'POST',
            url: 'http://localhost/SoftwareSupply/backend/api/api.php?type=update_profile',
            data: JSON.stringify({
                request_type: 'update_profile',
                ...updatedData
            }),
            contentType: 'application/json',
            success: function (response) {
                // Handle the response after successfully saving the data
                if (response.status === 'success') {
                    console.log('Data saved successfully!');
                    // You can provide a success message or perform any additional actions here
                } else {
                    console.log('Error saving data');
                    // Handle the error if the data could not be saved
                }
            },
            error: function (xhr, status, error) {
                console.log('Error saving data');
                // Handle the error if the data could not be saved
            }
        });

        // Disable editing and switch back to the edit button
        disableEdit();
    }

    // Function to disable editing of user data
    function disableEdit() {
        $('.profile-section span').attr('contenteditable', 'false');
        $('#saveButton').hide();
        $('#editButton').show();
        $('#payment').prop('disabled', true);
    }

    // Attach click event handlers to the edit and save buttons
    $('#editButton').click(enableEdit);
    $('#saveButton').click(saveData);

    // Call fetchUserProfile function on document ready
    fetchUserProfile();
});

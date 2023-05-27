$(document).ready(function() {
  function validateForm() {
    const salutation = $('#salutation').val();
    const vorname = $('#vorname').val();
    const nachname = $('#nachname').val();
    const adresse = $('#adresse').val();
    const plz = $('#plz').val();
    const ort = $('#ort').val();
    const email = $('#email').val();
    const username = $('#username').val();
    const password = $('#password').val();
    const confirmPassword = $('#confirm-password').val();

    if (
      salutation === '' ||
      vorname === '' ||
      nachname === '' ||
      adresse === '' ||
      plz === '' ||
      ort === '' ||
      email === '' ||
      username === '' ||
      password === '' ||
      confirmPassword === ''
    ) {
      alert('Bitte füllen Sie alle Felder aus.');
      return false;
    }

    if (plz.length !== 4) {
      alert('Die PLZ muss aus 4 Zahlen bestehen.');
      return false;
    }

    if (password !== confirmPassword) {
      alert('Die Passwörter stimmen nicht überein.');
      return false;
    }

    if (password.length < 8) {
      alert('Das Passwort muss mindestens 8 Zeichen lang sein.');
      return false;
    }

    const emailRegex = /\S+@\S+\.\S+/;
    if (!emailRegex.test(email)) {
      alert('Bitte geben Sie eine gültige E-Mail-Adresse ein.');
      return false;
    }

    return true;
  }

  function registerUser() {
    if (!validateForm()) {
      return;
    }
  
    var salutation = $('#salutation').val();
    var vorname = $('#vorname').val();
    var nachname = $('#nachname').val();
    var adresse = $('#adresse').val();
    var plz = $('#plz').val();
    var ort = $('#ort').val();
    var email = $('#email').val();
    var username = $('#username').val();
    var password = $('#password').val();
  
    var data = {
      salutation: salutation,
      vorname: vorname,
      nachname: nachname,
      adresse: adresse,
      plz: plz,
      ort: ort,
      email: email,
      username: username,
      password: password
    };
  
    $.ajax({
      type: 'POST',
      url: '../../../backend/api/api.php',
      data: JSON.stringify(data),
      contentType: 'application/json',
      success: function (response) {
        if (response.status === 'success') {
          $('#success-message').removeClass('d-none'); // Show the success message
          window.location.href = 'success.html';
          console.log(response.message);
          console.log('success');
        } else {
          alert(response.message);
          console.log(response.message);
          console.log('error');
        }
      },
      error: function () {
        alert('Error: Could not connect to the server.');
      }
    });
  }

  $('form').submit(function(event) {
    event.preventDefault(); 

    registerUser();
  });
});

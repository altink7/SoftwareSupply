function registerUser() {
    var salutation = $('#salutation').val();
    var vorname = $('#vorname').val();
    var nachname = $('#nachname').val();
    var adresse = $('#adresse').val();
    var plz = $('#plz').val();
    var ort = $('#ort').val();
    var email = $('#email').val();
    var username = $('#username').val();
    var password = $('#password').val();
    
    $.ajax({
      type: 'POST',
      url: 'dataHandler.php', 
      data: {
        salutation: salutation,
        vorname: vorname,
        nachname: nachname,
        adresse: adresse,
        plz: plz,
        ort: ort,
        email: email,
        username: username,
        password: password
      },
      success: function(response) {
        if (response.status == 'success') {
          window.location.href = 'success.html';
        } else {
          alert(response.message);
        }
      },
      error: function() {
        alert('Error: Could not connect to server.');
      }
    });
  }
  
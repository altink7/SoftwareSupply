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
      url: '../backend/config/dataHandler.php', 
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
            console.log(response.message);
            console.log("success");
        } else {
          alert(response.message);
            console.log(response.message);
            console.log("error");
        }
      },
      error: function() {
        alert('Error: Could not connect to server.');
      }
    });
  }
  
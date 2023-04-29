function validateForm() {
    const salutation = document.getElementById("salutation");
    const vorname = document.getElementById("vorname");
    const nachname = document.getElementById("nachname");
    const adresse = document.getElementById("adresse");
    const plz = document.getElementById("plz");
    const ort = document.getElementById("ort");
    const email = document.getElementById("email");
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");
    
    if (salutation.value === "" || vorname.value === "" || nachname.value === "" ||
     adresse.value === "" || plz.value === "" || ort.value === "" || email.value === "" ||
      username.value === "" || password.value === "" || confirmPassword.value === "") {
      alert("Bitte füllen Sie alle Felder aus.");
      return false;
    }
  
    if (plz.value.length !== 4) {
      alert("Die PLZ muss aus 4 Zahlen bestehen.");
      return false;
    }
  
    if (password.value !== confirmPassword.value) {
      alert("Die Passwörter stimmen nicht überein.");
      return false;
    }
  
    if (password.value.length < 8) {
      alert("Das Passwort muss mindestens 8 Zeichen lang sein.");
      return false;
    }
  
    const emailRegex = /\S+@\S+\.\S+/;
    if (!emailRegex.test(email.value)) {
      alert("Bitte geben Sie eine gültige E-Mail-Adresse ein.");
      return false;
    }
  
    return true;
  }
  const registerForm = document.querySelector("form");
  registerForm.addEventListener("submit", function(event) {
    if (!validateForm()) {
      event.preventDefault();
    }
  });
  
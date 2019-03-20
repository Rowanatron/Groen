

function error_username() {
    var testable = document.getElementById("test_username");
    if (!testable.checkValidity()) {
        document.getElementById("error_username").innerHTML = "De gebruikersnaam moet minimaal 5 karakters bevatten";
    } else {
        document.getElementById("error_username").innerHTML = "";
    }
}

function error_password() {
    var testable = document.getElementById("test_password");
    if (!testable.checkValidity()) {
        document.getElementById("error_pass").innerHTML = "Het wachtwoord moet minimaal 8 karakters bevatten waarvan 1 hoofdletter, 1 kleine letter en 1 getal";
    } else {
        document.getElementById("error_pass").innerHTML = "";
    }

}

function error_password_repeat() {
    var testable = document.getElementById("test_password_repeat");
    if (testable.value != document.getElementById("test_password").value) {
        document.getElementById("error_pass_repeat").innerHTML = "De wachtwoorden komen niet overeen";
    } else {
        document.getElementById("error_pass_repeat").innerHTML = "";
    }

}

function error_given_name() {
    var testable = document.getElementById("test_given_name");
    if (!testable.checkValidity()) {
        document.getElementById("error_given_name").innerHTML = "De voornaam moet minimaal 2 karakters bevatten";
    } else {
        document.getElementById("error_given_name").innerHTML = "";
    }

}

function error_family_name() {
    var testable = document.getElementById("test_family_name");
    if (!testable.checkValidity()) {
        document.getElementById("error_family_name").innerHTML = "De achternaam moet minimaal 2 karakters bevatten";
    } else {
        document.getElementById("error_family_name").innerHTML = "";
    }

}

function error_email() {
    var testable = document.getElementById("test_email");
    if (!testable.checkValidity()) {
        document.getElementById("error_email").innerHTML = "Dit is geen geldig emailadres";
    } else {
        document.getElementById("error_email").innerHTML = "";
    }

}

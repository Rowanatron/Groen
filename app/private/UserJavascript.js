

function errorUsername(){
                var testable = document.getElementById("testUsername");
                if (!testable.checkValidity()) {
                document.getElementById("errorUser").innerHTML = "De gebruikersnaam moet minimaal 5 karakters bevatten";
            } else {
                document.getElementById("errorUser").innerHTML = "";
            }

            }

function errorPassword(){
                var testable = document.getElementById("testPassword");
                if (!testable.checkValidity()) {
                document.getElementById("errorPass").innerHTML = "Het wachtwoord moet minimaal 8 karakters bevatten waarvan 1 hoofdletter, 1 kleine letter en 1 getal";
            } else {
                document.getElementById("errorPass").innerHTML = "";
            }

            }

function errorPasswordRepeat(){
                var testable = document.getElementById("testPasswordRepeat");
                if (testable.value != document.getElementById("testPassword").value) {
                document.getElementById("errorPassRepeat").innerHTML = "De wachtwoorden komen niet overeen";
            } else {
                document.getElementById("errorPassRepeat").innerHTML = "";
            }

            }

function errorGivenname(){
                 var testable = document.getElementById("testGivenname");
                if (!testable.checkValidity()) {
                document.getElementById("errorGiven").innerHTML = "De voornaam moet minimaal 2 karakters bevatten";
            } else {
                document.getElementById("errorGiven").innerHTML = "";
            }

            }

function errorFamilyname(){
                 var testable = document.getElementById("testFamilyname");
                if (!testable.checkValidity()) {
                document.getElementById("errorFamily").innerHTML = "De achternaam moet minimaal 2 karakters bevatten";
            } else {
                document.getElementById("errorFamily").innerHTML = "";
            }

            }

function errorEmailadres(){
                 var testable = document.getElementById("testEmail");
                if (!testable.checkValidity()) {
                document.getElementById("errorEmail").innerHTML = "Dit is geen geldig emailadres";
            } else {
                document.getElementById("errorEmail").innerHTML = "";
            }

            }

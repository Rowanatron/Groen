

function error_environent() {
    var testable = document.getElementById("test_environment_name");
    if (!testable.checkValidity()) {
        document.getElementById("error_environment_name").innerHTML = "De omgevingsnaam moet minimaal 3 karakters bevatten";
    } else {
        document.getElementById("error_username_name").innerHTML = "";
    }
}
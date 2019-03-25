function error_customer_name() {
    var testable = document.getElementById("test_customer_name");
    if (!testable.checkValidity()) {
        document.getElementById("error_customer_name").innerHTML = "De klantnaam moet minimaal 2 karakters bevatten";
    } else {
        document.getElementById("error_customer_name").innerHTML = "";
    }
}
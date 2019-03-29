function error_customer_name() {
    var customer_name = document.getElementById("test_customer_name");
        if (!customer_name.checkValidity()) {
        document.getElementById("error_customer_name").innerHTML = "De klantnaam moet minimaal 2 karakters bevatten";
    } else {
        document.getElementById("error_customer_name").innerHTML = "";
    }
}
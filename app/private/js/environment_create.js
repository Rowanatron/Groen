

function error_environment_name() {
    var testable = document.getElementById("test_environment");
    if (!testable.checkValidity()) {
        document.getElementById("error_environment").innerHTML = "De omgevingsnaam moet minimaal 3 karakters bevatten";
    } else {
        document.getElementById("error_environment").innerHTML = "";
    }
}

function error_description() {
    var testable = document.getElementById("test_description");
    if (!testable.checkValidity()) {
        document.getElementById("error_description").innerHTML = "De omschrijving mag maximaal 225 tekens lang zijn";
    } else {
        document.getElementById("error_description").innerHTML = "";
    }
}

var counter = 1;

function add_input(div_name){
        var new_div = document.createElement('div');
        new_div.innerHTML = "Relatie" + (counter + 1) + document.getElementById(div_name);
        document.getElementById(div_name).appendChild(newdiv);
        counter++;

}
var username = document.getElementById("username");
var password = document.getElementById("password");
var password_repeat = document.getElementById("password_repeat");
var given_name = document.getElementById("given_name");
var family_name = document.getElementById("family_name");
var email = document.getElementById("email");

//check input after typing
username.onchange = error_username;
password.onchange = error_password;
password_repeat.onchange = error_password_repeat;
given_name.onchange = error_given_name;
family_name.onchange = error_family_name;
email.onchange = error_email;

function error_username(){
if(!username.checkValidity()){
document.getElementById("error_username").innerHTML = "De gebruikersnaam moet minimaal 5 karakters bevatten";
} else{
document.getElementById("error_username").innerHTML = "";
}
}

function error_password() {
if (!password.checkValidity()) {
document.getElementById("error_password").innerHTML = "Het wachtwoord moet minimaal 8 karakters bevatten waarvan 1 hoofdletter, 1 kleine letter en 1 getal";
} else{
document.getElementById("error_password").innerHTML = "";
}
}

function error_password_repeat() {
if (!password_repeat.checkValidity()) {
document.getElementById("error_password_repeat").innerHTML = "De wachtwoorden komen niet overeen";
} else {
document.getElementById("error_password_repeat").innerHTML = "";
}
}

function error_given_name() {
if (!given_name.checkValidity()) {
document.getElementById("error_given_name").innerHTML = "De voornaam moet minimaal 2 karakters bevatten";
} else {
document.getElementById("error_given_name").innerHTML = "";
}
}

function error_family_name() {
if (!family_name.checkValidity()) {
document.getElementById("error_family_name").innerHTML = "De achternaam moet minimaal 2 karakters bevatten";
} else {
document.getElementById("error_family_name").innerHTML = "";
}
}

function error_email() {
if (!email.checkValidity()) {
document.getElementById("error_email").innerHTML = "Dit is geen geldig emailadres";
} else {
document.getElementById("error_email").innerHTML = "";
}
}
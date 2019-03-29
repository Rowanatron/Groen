var password = document.getElementById("password");
var password_repeat = document.getElementById("password_repeat");

var repeat_has_input = false;

password_repeat.onchange = unequal_passwords;
password_repeat.onkeyup = equal_passwords;

password.onchange = unequal_passwords;
password.onkeyup = equal_passwords;

function unequal_passwords(){
	if (password_repeat.value != "") {
		repeat_has_input = true;
	}
	if(repeat_has_input && password.value != password_repeat.value) {
		password_repeat.setCustomValidity("De wachtwoorden komen niet overeen.");
	}
}

function equal_passwords(){
	if(password.value == password_repeat.value) {
		password_repeat.setCustomValidity('');
	}
}
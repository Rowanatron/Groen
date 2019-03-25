function show_modal(username, form) {
	document.getElementById("modal").style.visibility = "visible";
	document.getElementById("modal-username").innerHTML = username;
	document.getElementById("modal-delete-button").setAttribute("form", form);
} 

function hide_modal() {
	document.getElementById("modal").style.visibility = "hidden";
	document.getElementById("modal-username").innerHTML = null;
	document.getElementById("modal-delete-button").setAttribute("form", null);
}
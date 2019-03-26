function show_modal(name, form) {
	document.getElementById("modal").style.visibility = "visible";
	document.getElementById("modal-name").innerHTML = name;
	document.getElementById("modal-delete-button").setAttribute("form", form);
} 

function hide_modal() {
	document.getElementById("modal").style.visibility = "hidden";
	document.getElementById("modal-name").innerHTML = null;
	document.getElementById("modal-delete-button").setAttribute("form", null);
}
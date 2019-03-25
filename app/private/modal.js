function showModal(username, form) {
	document.getElementById("modal").style.visibility = "visible";
	document.getElementById("modal-username").innerHTML = username;
	document.getElementById("modal-delete-button").setAttribute("form", form);
} 

function hideModal() {
	document.getElementById("modal").style.visibility = "hidden";
	document.getElementById("modal-username").innerHTML = null;
	document.getElementById("modal-delete-button").setAttribute("form", null);
}
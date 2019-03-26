var input = document.getElementById('input-img');
var button = document.getElementById('button-input-img');

input.addEventListener('change', display_filename);

function display_filename(event) {
	// get image name from input
	var image_name = event.srcElement.files[0].name;
	// display on button
	button.textContent = 'Afbeelding: ' + image_name;
}
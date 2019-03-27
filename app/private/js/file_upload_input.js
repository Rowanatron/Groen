var image_input = document.getElementById('photo');
var image_input_button = document.getElementById('photo-button');
var image_input_button_text = image_input_button.textContent;

image_input.addEventListener('change', display_filename);

function display_filename(event) {
	// get image name from input
	var image_name = event.srcElement.files[0].name;
	if (image_name.length > 0) {
		// display file name on button
		image_input_button.textContent = 'Afbeelding: ' + image_name;		
	} else {
		// display default text
		image_input_button.textContent = image_input_button_text;
	}
}
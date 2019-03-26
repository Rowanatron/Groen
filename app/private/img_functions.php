<?php
	
function upload_file($id, $file) {
	
	// Define where to safe img
	$target_dir = "img/uploads/";
	// Get filetype from upload
	$extension = strtolower(pathinfo(basename($_FILES["user_img"]["name"]),PATHINFO_EXTENSION));
	// Save file as
	$target_file_name = $id . "." . $extension;
	// Full location and filename
	$target_location = $target_dir . $target_file_name;

	// Check if image
	$check = getimagesize($_FILES["user_img"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
	} else {
		$errormsg = "File is not an image.";
	}

	// Check file size
	if ($_FILES["user_img"]["size"] > 500000) {
		$errormsg = "File is too large.";
	}

	// Check if filetype is ok
	if($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif" ) {
		$errormsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	}

	// Check if $uploadOk is set to 0 by an error
	if (isset($errormsg)) {
		echo $errormsg;
	} else {
		if (move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_location)) {
			echo "The file ". $target_location . " has been uploaded.";
			return $target_file_name;
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}

}

?>
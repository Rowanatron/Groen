<?php
	
function upload_file($id) {
	
	// Define where to safe img
	$target_dir = "img/uploads/";
	// Get filetype from upload
	$extension = strtolower(pathinfo(basename($_FILES["user_img"]["name"]),PATHINFO_EXTENSION));
	// Save file as
	$target_file_name = $id . "." . $extension;
	// Full location and filename
	$target_location = $target_dir . $target_file_name;

	// Check if filetype is ok
	if($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif" ) {
		return false;
	} else if (move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_location)) {
		return $target_file_name;
	} else {
		return false;
	}

}

function upload_img($file_var_name, $id) {
	
	// Define where to safe img
	$target_dir = "img/uploads/";
	// Get filetype from upload
	$extension = strtolower(pathinfo(basename($_FILES[$file_var_name]["name"]),PATHINFO_EXTENSION));
	// Save file as
	$target_file_name = $id . "." . $extension;
	// Full location and filename
	$target_location = $target_dir . $target_file_name;

	// Check if filetype is ok
	if($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif" ) {
		return false;
	// Uploaden
	} else if (move_uploaded_file($_FILES[$file_var_name]["tmp_name"], $target_location)) {
		return $target_file_name;
	} else {
		return false;
	}

}

?>
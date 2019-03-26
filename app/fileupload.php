<?php

require_once('private/path_constants.php');
require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/user_functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
require_once(CLASS_PATH . '/User.php');

$page_title = 'Upload profielfoto';

session_start();

session_expired();
is_logged_in();

include(SHARED_PATH . '/header.php');

if(isset($_POST["submit"])) {
$current_user = $_SESSION["user"];
$target_dir = "img/uploads/";
$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
$target_file_name = $current_user->get_user_id() . "." . $imageFileType;
$target_file = $target_dir . $target_file_name;
$uploadOk = 1;

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$current_user->set_img($target_file_name);
upload_img($current_user);
}
?>

<!-- Hier komt de content -->
<div id="content" class="container">

	<form action="fileupload.php" method="post" enctype="multipart/form-data">
		Select image to upload:
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Upload Image" name="submit">
	</form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

<?php

//// INCLUDES
// Global
require_once('private/path_constants.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
// Page specific functions
require_once(PRIVATE_PATH . '/user_functions.php');
// Class
require_once(CLASS_PATH . '/User.php');

// Start and check for session
session_start();
is_logged_in();
session_expired();

// Current user
$session_user = get_user_by_id($_SESSION["user"]->get_user_id());

//// GET REQUEST

// Check method
if (isset($_POST['id'])) {
	$is_post = true;
} else {
	$is_post = false;
}

// Check action
if (isset($_GET['action']) && $_GET['action'] == "new") {
	
	$get_action = "new";
	$page_title = "Nieuwe gebruiker";
	
} else if (isset($_GET['action']) && $_GET['action'] != "edit") {
	
	header("Location: user-edit");

} else {
	
	$get_action = "edit";
	$page_title = "Gebruiker bewerken";

}

// Check id
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	
	$get_id = $_GET['id'];
	
} else {
	
	$get_id = $session_user->get_user_id();
	
}

// Check if user rights are ok
if ($session_user->get_role() != "admin") {
	
	if ($get_action == "new" || $get_id != $session_user->get_user_id()) {
		header("Location: user-edit");
	}
	
}

//// POST REQUEST

?>

<?php if ($is_post) : ?>
	<script>alert("POST");</script>
<?php endif; ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<div id="content" class="container">
	<div class="table-header-container">
		<h2 class="tabel-header"><?= $page_title ?></h2>
		<?= $post ? "post" : "get" ?>
		<?= $get_action ?>
		<?= $get_id ?>
		<a href="user" />User</a>
	</div>

    <form id="user-form" method="post" action="user-<?= $get_action ?><?= $get_action == "edit" ? "-" . $get_id : "" ?>" enctype="multipart/form-data">
	
        <div class="form_container">
		
			<div class="form_block form_full_length">
				<label for="id">Id</label>
				<input name="id" type="text" value="1" required />
			</div> 
			
			<div class="form_block form_full_length">
				<label for="username">Gebruikersnaam</label>
				<input name="username" type="text" minlength="5" maxlength="45" value="123456" required />
                <p id="error_username" class="error_message"></p>
			</div> 
			
            <div class="form_block">
                <label for="password">Wachtwoord</label>
                <input name="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" value="Minimal1!" />
                <p id="error_password" class="error_message"></p>
            </div>
			
            <div class="form_block">
                <label for="password_repeat">Herhaal wachtwoord</label>
                <input id="password_repeat" name="password_repeat" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" value="Minimal1!" />
                <p id="error_password_repeat" class="error_message"></p>
            </div>
   			
            <div class="form_block">
                <label for="given_name">Voornaam</label>
                <input name="given_name" type="text" minlength="2" maxlenght="45" required value="Minimal1!" />
                <p id="error_given_name" class="error_message"></p>
            </div>
			
            <div class="form_block">
                <label for="family_name">Achternaam</label>
				<input id="family_name" name="family_name" type="text" minlength="2" maxlenght="45" required value="Minimal1!" />
                <p id="error_family_name" class="error_message"></p>
            </div>
			
            <div class="form_block form_full_length">
                <label for="email">Emailadres</label>
				<input id="email" name="email" type="email" maxlength="45" required value="Minimal1@gmail.com" />
                <p id="error_email" class="error_message"></p>
            </div>
			
            <div class="form_block form_full_length">
                <label for="role">Selecteer rol:</label>
                <select name="role" id="role" required>
					<option value="user" selected>gebruiker</option>
                    <option value="admin">admin</option>
				</select>
            </div>
			
            <div class="form_block form_full_length">
                <label for="photo">Upload profielfoto
					<div id="button-input-photo">Bladeren...</div>
				</label>
				<input id="photo" name="photo" type="file">
		    </div> 
			
        </div>
		
    </form>
	
    <div class="buttons_bottom">
        <button class="btn-user-save" form="user-form" type="submit">Gebruiker opslaan</button>
		<button class="btn-user-delete">Gebruiker verwijderen</button>
        <button class="btn-user-cancel">Annuleren</button>
    </div>   
    
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

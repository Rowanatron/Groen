<?php

//// INCLUDES
// Global
require_once('private/path_constants.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
// Page specific functions
require_once(PRIVATE_PATH . '/user_functions.php');
require_once(PRIVATE_PATH . '/img_functions.php');
// Class
require_once(CLASS_PATH . '/User.php');

// Start and check for session
session_start();
is_logged_in();
session_expired();

// Initialize
$page_errors = array();

// Current user
$session_user = get_user_by_id($_SESSION["user"]->get_user_id());

if ($session_user->get_role() == "admin") {
	$is_admin = true;
} else {
	$is_admin = false;
}

//// CHECK REQUEST

// Check action
if (isset($_GET['action']) && $_GET['action'] == "new") {
	$is_edit = false;
	$page_title = "Nieuwe gebruiker";
} else if (isset($_GET['action']) && $_GET['action'] != "edit") {
	header("Location: user-edit");
} else {
	$is_edit = true;
	$page_title = "Gebruiker bewerken";
}

// Check id
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$get_id = $_GET['id'];
} else {
	$get_id = $session_user->get_user_id();
}

// Check if user rights are ok
if (!$is_admin) {
	if (!$is_edit || $get_id != $session_user->get_user_id()) {
		header("Location: user-edit");
	}
}

?>

<?php
//// POST REQUEST
if (isset($_POST['username'])) {
	
	// Check ingevulde gegevens compleet
	
	// Username
	if (!isset($_POST['username'])) {
		array_push($page_errors, "Gebruikersnaam is leeg.");
		$empty_value = true;
	} else if (strlen($_POST['username']) < 5) {
		array_push($page_errors, "De gebruikersnaam moet minimaal 5 karakters bevatten");
		$empty_value = true;
	} else if (strlen($_POST['username']) > 45) {
		array_push($page_errors, "De gebruikersnaam mag maximaal 45 karakters bevatten");
		$empty_value = true;
	} else {
		$post_username = $_POST['username'];
	}
	
	// Voornaam
	if (!isset($_POST['given_name'])) {
		array_push($page_errors, "Voornaam is leeg.");
		$empty_value = true;
	} else if (strlen($_POST['given_name']) < 2) {
		array_push($page_errors, "De voornaam moet minimaal 2 karakters bevatten");
		$empty_value = true;
	} else if (strlen($_POST['given_name']) > 45) {
		array_push($page_errors, "De voornaam mag maximaal 45 karakters bevatten");
		$empty_value = true;
	} else {
		$post_given_name = $_POST['given_name'];
	}
	
	// Achternaam
	if (!isset($_POST['family_name'])) {
		array_push($page_errors, "Achternaam is leeg.");
		$empty_value = true;
	} else if (strlen($_POST['given_name']) < 2) {
		array_push($page_errors, "De achternaam moet minimaal 2 karakters bevatten");
		$empty_value = true;
	} else if (strlen($_POST['given_name']) > 45) {
		array_push($page_errors, "De achternaam mag maximaal 45 karakters bevatten");
		$empty_value = true;
	} else {
		$post_family_name = $_POST['family_name'];
	}
	
	// Email
	if (!isset($_POST['email'])) {
		array_push($page_errors, "E-mail is leeg.");
		$empty_value = true;		
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		array_push($page_errors, "Dit is geen geldig emailadres");
		$empty_value = true;
	} else {
		$post_email = $_POST['email'];
	}
	
	// Rol
	if (!isset($_POST['role'])) {
		array_push($page_errors, "Rol is leeg.");
		$empty_value = true;
	} else if ($_POST['role'] != "admin" && $_POST['role'] != "user") {
		array_push($page_errors, "Dit is geen geldige rol.");
		$empty_value = true;
	} else {
		$post_role = $_POST['role'];
	}
	
	// Check wachtwoord
	if (isset($_POST['password'])) {
		
		if($_POST['password'] != $_POST['password_repeat']) {
			array_push($page_errors, "Wachtwoorden komen niet overeen.");
			$empty_value = true;
		} else if (strlen($_POST['password']) < 8 || preg_match('~[A-Z]~', $_POST['password']) == 0 || preg_match('~[0-9]~', $_POST['password']) == 0 || preg_match('~[a-z]~', $_POST['password']) == 0) {
			array_push($page_errors, "Het wachtwoord moet minimaal 8 karakters bevatten waarvan 1 hoofdletter, 1 kleine letter en 1 getal.");
			$empty_value = true;
		} else {
			$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		}
		
	} else if (!$is_edit) {
		array_push($page_errors, "Wachtwoord is leeg.");
		$empty_value = true;
	}
	
	// Check id
	if ($is_edit && isset($_POST['id']) && $_POST['id'] == $get_id) {
		
		$post_id = $_POST['id'];
	
	} else if ($is_edit) {
		
		array_push($page_errors, "Gebruiker en data komen niet overeen.");
		$empty_value = true;
		
	}
	
	// Create user object to input in database
	$post_user = new User(null, (isset($post_username) ? $post_username : null), null, (isset($post_given_name) ? $post_given_name : null), (isset($post_family_name) ? $post_family_name : null), (isset($post_email) ? $post_email : null), (isset($post_role) ? $post_role : null));
	
	if (!isset($empty_value)) {
		
		if (isset($hashed_password)) {
			$post_user->set_password($hashed_password);
		}
		if (isset($post_id)) {
			$post_user->set_user_id($post_id);
		}
		if (isset($img_filename)) {
			$post_user->set_img($img_filename);
		}
		
		// Put in database
		if (!$is_edit) {
			$result = insert_user($post_user);

		} else {
			$result = custom_update_user($post_user);
		}
		
		// Check for errors, if succeeded continue to upload image
		if (empty($result)) {
			$new_id = get_user_id_by_username($post_user->get_username());
			$post_user->set_user_id($new_id);
			
			// Check for image
			if ($_FILES['img']['size'] > 0) {
				// Upload file
				$img_filename = upload_img('img', $post_user->get_user_id());
				// Check if upload succeeded
				if ($img_filename == false) {
					array_push($page_errors, "Uploaden is mislukt.");
				} else {
					$post_user->set_img($img_filename);
					$result = update_user_img($post_user);
					if (isset($result)) {
						array_push($page_errors, $result);
					}
				}
			}
		} else {
			array_push($page_errors, $result);	
		}
		
		if (sizeof($page_errors) == 0) {
			header("Location: " . ($is_admin? userlist : systemoverview));
		} else if (!$is_edit) {
			echo "create";
		}
	}

}

?>

<?php

//// GET FORM-USER
if (isset($form_user)) {
	$form_user = $post_user;
} else if ($is_edit == true) {
	$form_user = get_user_by_id($get_id);
	if ($form_user->get_user_id() == null) {	
	header("Location: user-edit");
	}
}

?>

<!-- Header -->
<?php include(SHARED_PATH . '/header.php'); ?>

<!-- Content -->
<div id="content" class="container">

	<!-- Header -->
	<div class="table-header-container">
		<h2 class="tabel-header"><?= $page_title ?></h2>
	</div>
	
	<!-- Form -->
    <form id="user-form" method="post" action="user-<?= ($is_edit) ? "edit-" . $get_id : "new" ?>" enctype="multipart/form-data">
	
        <div class="form_container">
			
			<?php if($is_edit) : ?>
				<input name="id" type="hidden" value="<?= isset($form_user) ? $form_user->get_user_id() : "0" ; ?>" required />
			<?php endif; ?>
			
			<div class="form_block form_full_length">
				<label for="username">Gebruikersnaam</label>
				<input name="username" type="text" minlength="5" maxlength="45" value="<?php if (isset($form_user)) echo $form_user->get_username(); ?>" required <?php if (!$is_admin) echo "disabled"; ?> />
                <p id="error_username" class="error_message"></p>
			</div> 
			
            <div class="form_block">
                <label for="password">Wachtwoord</label>
                <input name="password" type="password" <?php if(!$is_edit) echo "required"; ?> />
                <p id="error_password" class="error_message"></p>
            </div>
			
            <div class="form_block">
                <label for="password_repeat">Herhaal wachtwoord</label>
                <input id="password_repeat" name="password_repeat" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" <?php if(!$is_edit) echo "required"; ?>  />
                <p id="error_password_repeat" class="error_message"></p>
            </div>
   			
            <div class="form_block">
                <label for="given_name">Voornaam</label>
                <input name="given_name" type="text" minlength="2" maxlenght="45" required value="<?php if($is_edit) echo $form_user->get_given_name(); ?>" />
                <p id="error_given_name" class="error_message"></p>
            </div>
			
            <div class="form_block">
                <label for="family_name">Achternaam</label>
				<input id="family_name" name="family_name" type="text" minlength="2" maxlenght="45" required value="<?php if($is_edit) echo $form_user->get_family_name(); ?>" />
                <p id="error_family_name" class="error_message"></p>
            </div>
			
            <div class="form_block form_full_length">
                <label for="email">Emailadres</label>
				<input id="email" name="email" type="email" maxlength="45" required value="<?php if($is_edit) echo $form_user->get_email(); ?>" />
                <p id="error_email" class="error_message"></p>
            </div>
			
            <div class="form_block form_full_length">
                <label for="role">Selecteer rol</label>
                <select name="role" id="role" <?php if (!$is_admin) echo "disabled"; ?> required>
					<?php if(!$is_edit) : ?>
						<option disabled selected hidden>Kies een rol</option>
					<?php endif; ?>
					<option value="user" <?php if($is_edit && $form_user->get_role() == "user") echo "selected"; ?>>gebruiker</option>
                    <option value="admin" <?php if($is_edit && $form_user->get_role() == "admin") echo "selected"; ?>>admin</option>
				</select>
            </div>
			
            <div class="form_block form_full_length">
                <label for="img">
					Upload profielfoto
					<div id="img-button">Bladeren...</div>
				</label>
				<input id="img" name="img" type="file">
		    </div> 
			
        </div>
		
    </form>
	
	<!-- Buttons -->
    <div class="buttons_bottom">
        <button class="btn-user-save" form="user-form" type="submit">Gebruiker opslaan</button>
		<?php if ($is_edit && $is_admin && $session_user->get_user_id() != $get_id) : ?>
			<button class="btn-user-delete" onclick="show_modal_edit_page('modal_delete')">Gebruiker verwijderen</button>
		<?php endif; ?>
		<form action="<?= (!$is_admin || !isset($_GET['id']) ) ? "systemoverview" : "userlist" ?>" method="get" class="borderless_form">
            <button class="btn-user-cancel">Annuleren</button>
		</form>
    </div>
    
</div>

<!-- Modal for delete -->
<?php if ($is_edit && $is_admin && $session_user->get_user_id() != $get_id) : ?>
<div class="modal" id="modal_delete">
	<div id="modal-content">
		<div id="modal-title"><h1>Gebruiker verwijderen</h1></div>
		<div id="modal-p"><p>Weet u zeker dat u <?= $form_user->get_username() ?> wilt verwijderen?</p></div>
		<div id="button-container">
			<form id="user-delete" action="userlist">
				<input type="hidden" value="<?= $get_id ?>" />
			</form>
			<button id="modal-delete-button" class="verwijderen" form="user-delete" type="submit" name="action" value="delete_user">Gebruiker verwijderen</button>
			<button onclick="hide_modal_edit_page('modal_delete')" class="annuleren">Annuleren</button>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- Modal for error -->
<?php foreach ($page_errors as $key => $error): ?>
<div class="modal visible" id="modal_error_<?= $key ?>">
	<div class="modal-content">
		<div class="modal-title"><h1>Foutmelding</h1></div>
		<div class="modal-p"><p><?= $error ?></p></div>
		<div class="button-container">
			<button onclick="hide_modal_edit_page('modal_error_<?= $key ?>')" class="annuleren">Annuleren</button>
		</div>
	</div>
</div>
<?php endforeach; ?>

<!-- Footer -->
<?php include(SHARED_PATH . '/footer.php'); ?>

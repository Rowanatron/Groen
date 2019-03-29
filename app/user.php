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

<?php if (isset($_POST['username'])) include(PRIVATE_PATH . '/user_post.php'); ?>

<?php

//// GET FORM-USER
if ($is_edit == true) {
	$form_user = get_user_by_id($get_id);
	if ($form_user->get_user_id() == null) {	
	header("Location: user-edit");
	}
} else if (isset($post_user)) {
	$form_user = $post_user;
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
				<input name="id" type="hidden" value="<?= isset($form_user) ? $form_user->get_user_id() : "" ; ?>" required />
			<?php endif; ?>
			
			<div class="form_block form_full_length">
				<label for="username">Gebruikersnaam</label>
				<input id="username" name="username" type="text" minlength="5" maxlength="45" value="<?php if (isset($form_user)) echo $form_user->get_username(); ?>" required <?php if (!$is_admin) echo 'readonly="readonly"'; ?> />
                <p id="error_username" class="error_message"></p>
			</div> 
			
            <div class="form_block">
                <label for="password">Wachtwoord</label>
                <input id="password" name="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" <?php if(!$is_edit) echo "required"; ?> />
                <p id="error_password" class="error_message"></p>
            </div>
			
            <div class="form_block">
                <label for="password_repeat">Herhaal wachtwoord</label>
                <input id="password_repeat" name="password_repeat" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" <?php if(!$is_edit) echo "required"; ?>  />
                <p id="error_password_repeat" class="error_message"></p>
            </div>
   			
            <div class="form_block">
                <label for="given_name">Voornaam</label>
                <input id="given_name" name="given_name" type="text" minlength="2" maxlenght="45" required value="<?php if (isset($form_user)) echo $form_user->get_given_name(); ?>" />
                <p id="error_given_name" class="error_message"></p>
            </div>
			
            <div class="form_block">
                <label for="family_name">Achternaam</label>
				<input id="family_name" name="family_name" type="text" minlength="2" maxlenght="45" required value="<?php if (isset($form_user)) echo $form_user->get_family_name(); ?>" />
                <p id="error_family_name" class="error_message"></p>
            </div>
			
            <div class="form_block form_full_length">
                <label for="email">Emailadres</label>
				<input id="email" name="email" type="email" maxlength="45" required value="<?php if (isset($form_user)) echo $form_user->get_email(); ?>" />
                <p id="error_email" class="error_message"></p>
            </div>
			
            <div class="form_block form_full_length">
                <label for="role">Selecteer rol</label>
                <select name="role" id="role" <?php if (!$is_admin) echo 'readonly="readonly"'; ?> required>
					<?php if(!$is_edit) : ?>
						<option hidden selected disabled>Kies een rol</option>
					<?php endif; ?>
					<option value="user" <?= (isset($form_user) && $form_user->get_role() == "user") ? "selected" : ""; ?>>gebruiker</option>
                    <option value="admin" <?= (isset($form_user) && $form_user->get_role() == "admin") ? "selected" : ""; ?>>admin</option>
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
			<button onclick="hide_modal_edit_page('modal_error_<?= $key ?>')" class="annuleren">Ok</button>
		</div>
	</div>
</div>
<?php endforeach; ?>

<!-- Footer -->
<?php include(SHARED_PATH . '/footer.php'); ?>

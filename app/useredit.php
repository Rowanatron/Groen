<!-- Default PHP header -->
<?php

require_once('private/path_constants.php');

$page_title = 'Bewerk gebruiker';

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/user_functions.php');
require_once(PRIVATE_PATH . '/img_functions.php');
require_once(CLASS_PATH . '/User.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
require_once(PRIVATE_PATH . '/user_edit.php');

session_start();

is_logged_in();
session_expired();
only_for_admins();

include(SHARED_PATH . '/header.php');


if(isset($_POST['user_id'])) {
	$id = $_POST['user_id'];
	$username = $_POST['username'];
	$given_name = $_POST['given_name'];
	$family_name = $_POST['family_name'];
	$email = $_POST['email'];
	$role = $_POST['role'];

	$password = $_POST['password'];
	$repeat_password = $_POST['repeat_password'];
	
	$edit_user = new User($id, $username, $password, $given_name, $family_name, $email, $role);
    if ($_FILES['user_img']['size'] > 0) {
		// Upload file
		$img_filename = upload_file($id, $_FILES['user_img']);
		// Add filename to user
		$edit_user->set_img($img_filename);
		// Edit in database
		upload_img($edit_user);
	}
    edit_user($edit_user, $repeat_password);
} else if(isset($_GET['id'])) {
	$edit_user = get_user_by_id($_GET['id']);
} else {
	// header("Location: userlist");
}

?>

<!-- Hier komt de content -->
<div id="content" class="container">
	<div class="table-header-container">
		<h2 class="tabel-header">Gebruiker bewerken</h2>
	</div>

    <form method="post" action="useredit" id="form-edit" enctype="multipart/form-data">
        <input type=hidden name="user_id" value="<?=$edit_user->user_id; ?>"/>
        <input type=hidden name="original_username" value="<?=$edit_user->username; ?>"/>
        <div class="form_container">
            <div class="form_block form_full_length">
                <label>
                    Gebruikersnaam<br>
                    <input id="test_username" name="username" type="text" minlength="5" maxlength="45" onkeydown="setTimeout(error_username, 1500)" value="<?=$edit_user->username; ?>" required />
                </label>
                <br>
                <p id="error_username" class="error_message"></p>
            </div> 
            <div class="form_block">
                <label>
                    Wachtwoord<br>
                    <input id="test_password" name="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeydown="setTimeout(error_password, 1500)" />
                </label>
                <p id="error_pass" class="error_message"></p>
            </div>
            <div class="form_block">
                <label>
                    Herhaal wachtwoord<br>
                    <input id="test_password_repeat" name="repeat_password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeydown="setTimeout(error_password_repeat, 1500)" />
                </label>
                <p id="error_pass_repeat" class="error_message"></p>
            </div>        
            <div class="form_block">
                <label>
                    Voornaam <br>
                    <input id="test_given_name" name="given_name" type=text minlength="2" maxlenght="45" onkeydown="setTimeout(error_given_name, 1500)" value="<?=$edit_user->given_name; ?>" required />
                </label>
                <p id="error_given_name" class="error_message"></p>
            </div>
            <div class="form_block">
                <label>
                    Achternaam<br>
                    <input id="test_family_name" name="family_name" type=text minlength="2" maxlenght="45" onkeydown="setTimeout(error_family_name, 1500)" value="<?=$edit_user->family_name; ?>"required />
                </label>
                <p id="error_family_name" class="error_message"></p>
            </div>
            <div class="form_block form_full_length">
                <label>
                    Emailadres<br>
                    <input id="test_email" name="email" type="email" maxlength="45" onkeydown="setTimeout(error_email, 1500)" value="<?=$edit_user->email; ?>" required />
                </label>
                <p id="error_email" class="error_message"></p>
            </div>
            <div class="form_block form_full_length">
                <label for="role">Selecteer rol:</label><br>
                <select name="role" id="role" required>
                    <?php if ($edit_user->role == "user"){
                     ?>
                        <option value="user" selected>gebruiker</option>
                     <option value="admin">admin</option>
                    <?php } else {
                        ?>
                        <option value="admin" selected>admin</option>
                    <option value="user">gebruiker</option>
                    <?php 
                    }
                    ?>
                    
                </select>
            </div>
            <div class="form_block form_full_length">
                <label>
					Upload profielfoto:
					<div id="button-input-img">Upload profielfoto</div>
					<input id="input-img" style="width: 1px;" type="file" name="user_img" id="user_img">
				</label>
            </div>  
        </div>  
    </form>
    <form style="display:none;" method="post" action="userlist" id="form-delete">
		<input type="hidden" name="action" value="delete_user" />
        <input type="hidden" name="user_id" value="<?=$edit_user->user_id; ?>"/>
        <input type="hidden" name="username" value="<?=$edit_user->username; ?>"/>
    </form>
    <div class="buttons_bottom">
        <button class="btn-user-save" form="form-edit" type="submit">Gebruiker opslaan</button>
		<button class="btn-user-delete" id="show_modal" onclick="show_modal('<?= $edit_user->username; ?>', 'form-delete')" value="delete-user">Gebruiker verwijderen</button>
 <!--       <button class="btn-user-delete" form="form-delete" type="submit">Gebruiker verwijderen</button> -->
        <button class="btn-user-cancel" onclick="window.location.href = 'userlist';"> Annuleren </button>
    </div>       
</div>
<div class="modal" id="modal">
	<div id="modal-content">
		<div id="modal-title"><h1>Gebruiker verwijderen</h1></div>
		<div id="modal-p"><p>Weet u zeker dat u <span id="modal-name"></span> wilt verwijderen?</p></div>
		<div id="button-container">
			<button id="modal-delete-button" class="verwijderen" form="" type="submit">Gebruiker verwijderen</button>
			<button onClick="hide_modal()" class="annuleren">Annuleren</button>
		</div>
	</div>
</div>

<!-- Nu staat Javascript niet achteraan. Probleem? -->
<script type="text/javascript" src="private/js/user_crud.js"></script>
<script type="text/javascript" src="private/js/modal.js"></script>
<script type="text/javascript" src="private/js/check_for_input.js"></script>

<!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>
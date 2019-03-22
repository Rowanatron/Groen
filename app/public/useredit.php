<!-- Default PHP header -->
<?php

require_once('../private/path_constants.php');

$page_title = 'Bewerk gebruiker';

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/user_functions.php');
require_once(PRIVATE_PATH . '/User.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

session_start();

is_logged_in();
session_expired();
only_for_admins();

include(SHARED_PATH . '/header.php');
if($_POST['user_id'] == 0) {
    header("Location: userlist.php");
} else {
$user = get_user_by_id($_POST['user_id']);
}
?>

<!-- Hier komt de content -->
<div id="content" class="container">
	<div class="table-header-container">
		<h2 class="tabel-header">Gebruiker bewerken</h2>
	</div>

    <form method="post" action="../private/edit.php" id="form-edit">
        <input type=hidden name="user_id" value="<?=$user->user_id; ?>"/>
        <input type=hidden name="original_username" value="<?=$user->username; ?>"/>
        <div class="form_container">
            <div class="form_block form_full_length">
                <label>
                    Gebruikersnaam<br>
                    <input id="test_username" name="username" type="text" minlength="5" maxlength="45" onkeydown="setTimeout(error_username, 1500)" value="<?=$user->username; ?>" required/>
                </label>
                <br>
                <p id="error_username" class="error_message"></p>
            </div> 
            <div class="form_block">
                <label>
                    Wachtwoord<br>
                    <input id="test_password" name="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeydown="setTimeout(error_password, 1500)"/>
                </label>
                <p id="error_pass" class="error_message"></p>
            </div>
            <div class="form_block">
                <label>
                    Herhaal wachtwoord<br>
                    <input id="test_password_repeat" name="repeat_password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeydown="setTimeout(error_password_repeat, 1500)"/>
                </label>
                <p id="error_pass_repeat" class="error_message"></p>
            </div>        
            <div class="form_block">
                <label>
                    Voornaam <br>
                    <input id="test_given_name" name="given_name" type=text minlength="2" maxlenght="45" onkeydown="setTimeout(error_given_name, 1500)" value="<?=$user->given_name; ?>" required/>
                </label>
                <p id="error_given_name" class="error_message"></p>
            </div>
            <div class="form_block">
                <label>
                    Achternaam<br>
                    <input id="test_family_name" name="family_name" type=text minlength="2" maxlenght="45" onkeydown="setTimeout(error_family_name, 1500)" value="<?=$user->family_name; ?>"required/>
                </label>
                <p id="error_family_name" class="error_message"></p>
            </div>
            <div class="form_block form_full_length">
                <label>
                    Emailadres<br>
                    <input id="test_email" name="email" type="email" maxlength="45" onkeydown="setTimeout(error_email, 1500)" value="<?=$user->email; ?>" required/>
                </label>
                <p id="error_email" class="error_message"></p>
            </div>
            <div class="form_block form_full_length">
                <label for="role">Selecteer rol:</label><br>
                <select name="role" id="role" required>
                    <?php if ($user->role == "user"){
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
        </div>  
    </form>
    <form style="display:none;" method="post" action="userlist" id="form-delete" onsubmit="return confirm('Weet u zeker dat u <?=$user->username; ?> wilt verwijderen?');">
		<input type="hidden" name="action" value="delete_user" />
        <input type="hidden" name="user_id" value="<?=$user->user_id; ?>"/>
        <input type="hidden" name="username" value="<?=$user->username; ?>"/>
    </form>
    <div class="buttons_bottom">
        <button class="btn-user-save" form="form-edit" type="submit">Gebruiker opslaan</button>        
        <button class="btn-user-delete" form="form-delete" type="submit">Gebruiker verwijderen</button>
        <button class="btn-user-cancel" onclick="window.location.href = 'userlist';"> Annuleren </button>
    </div>       
</div>

<meta http-equiv="refresh" content="1801; ../public/login.php" />

<!-- Nu staat Javascript niet achteraan. Probleem? -->
<script type="text/javascript" src="../private/UserJavascript.js">
</script>

<!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>
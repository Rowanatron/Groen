<!-- Default PHP header -->
<?php

require_once('../private/pathConstants.php');

$page_title = 'Create user';
$page = "createuser";

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/userfunctions.php');
require_once(PRIVATE_PATH . '/User.php');

include(SHARED_PATH . '/header.php');

?>

<!-- Hier komt de content -->
<div id="content" class="container">

	<div class="table-header-container">
		<h2 class="tabel-header">Voeg gebruiker toe</h2>
	</div>

    <form method="post" action="../private/insert.php">

        <p>

            <label>
                Gebruikersnaam
                <input id="test_username" name="username" type="text" minlength="5" maxlength="45" onkeydown="setTimeout(error_username, 1500)" required/>
            </label>
            <p id="error_user"></p>

        </p>
        <p>

            <label>
                Wachtwoord
                <input id="test_password" name="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeydown="setTimeout(error_password, 1500)" required/>
            </label>
            <p id="error_pass"></p>

        </p>
        <p>

            <label>
                Herhaal wachtwoord
                <input id="test_password_repeat" name="repeat_password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeydown="setTimeout(error_password_repeat, 1500)" required/>
            </label>
            <p id="error_pass_repeat"></p>
        </p>
        
        <p>

            <label>
                Voornaam 
                <input id="test_given_name" name="given_name" type=text minlength="2" maxlenght="45" onkeydown="setTimeout(error_given_name, 1500)" required/>
            </label>
            <p id="error_given_name"></p>
        </p>
        <p>

            <label>
                Achternaam
                <input id="test_family_name" name="family_name" type=text minlength="2" maxlenght="45" onkeydown="setTimeout(error_family_name, 1500)" required/>
            </label>
            <p id="error_family_name"></p>
        </p>
        <p>

            <label>
                Emailadres
                <input id="test_email" name="email" type="email" maxlength="45" onkeydown="setTimeout(error_email_adres, 1500)"  required/>
            </label>
            <p id="error_email"></p>
        </p>


        <label for="role">Selecteer rol:</label>

        <select name="role" id="role" required>
            <option value="" disabled selected hidden>--Kies rol--</option>
            <option value="admin">admin</option>
            <option value="user">user</option>
        </select>

        <p>
        
            <input type="submit" value="Gebruiker aanmaken" />

            <button onclick="window.location.href = 'userlist.php';"> Annuleren </button>


        </p>


    </form>

</div>

<!-- Nu staat Javascript niet achteraan. Probleem? -->
<script type="text/javascript" src="../private/UserJavascript.js">
</script>

<!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>
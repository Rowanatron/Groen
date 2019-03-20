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
                <input id="testUsername" name="username" type=text minlength="5" maxlength="50" onkeydown="setTimeout(errorUsername, 1500)" required/>
            </label>
            <p id="errorUser"></p>

        </p>
        <p>

            <label>
                Wachtwoord
                <input id="testPassword" name="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeydown="setTimeout(errorPassword, 1500)" required/>
            </label>
            <p id="errorPass"></p>

        </p>
        <p>

            <label>
                Herhaal wachtwoord
                <input id="testPasswordRepeat" name="repeatpassword" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeydown="setTimeout(errorPasswordRepeat, 1500)" required/>
            </label>
            <p id="errorPassRepeat"></p>
        </p>
        
        <p>

            <label>
                Voornaam 
                <input id="testGivenname" name="givenname" type=text minlength="2" maxlenght="45" onkeydown="setTimeout(errorGivenname, 1500)" required/>
            </label>
            <p id="errorGiven"></p>
        </p>
        <p>

            <label>
                Achternaam
                <input id="testFamilyname" name="familyname" type=text minlength="2" maxlenght="45" onkeydown="setTimeout(errorFamilyname, 1500)" required/>
            </label>
            <p id="errorFamily"></p>
        </p>
        <p>

            <label>
                Emailadres
                <input id="testEmail" name="email" type="email" maxlength="45" onkeydown="setTimeout(errorEmailadres, 1500)"  required/>
            </label>
            <p id="errorEmail"></p>
        </p>


        <label for="role" required>Selecteer rol:</label>

        <select name="role" id="role">
            <option value="" disabled selected hidden>--Kies rol--</option>
            <option value="admin">admin</option>
            <option value="user">user</option>
        </select>

        <p>
        
            <input type="submit" value="gebruiker aanmaken" />

            <button onclick="window.location.href = 'userlist.php';"> annuleren </button>


        </p>


    </form>

</div>

<!-- Nu staat Javascript niet achteraan. Probleem? -->
<script type="text/javascript" src="../private/UserJavascript.js">
</script>

<!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>
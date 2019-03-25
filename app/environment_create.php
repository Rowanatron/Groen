<?php

require_once('../private/path_constants.php');

$page_title = 'Omgeving aanmaken';

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/Environment.php');
require_once(PRIVATE_PATH . '/environment_functions.php');
require_once(PRIVATE_PATH . '/Customer.php');
require_once(PRIVATE_PATH . '/customer_functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

session_start();

// authorisatiechecks. zie authorisation_functions.php
// de eerste twee functions worden aangeroepen op elke pagina
// de derde wordt aangeroepen op alle pagina's waar alleen admins mogen komen
is_logged_in();
session_expired();
only_for_admins();

include(SHARED_PATH . '/header.php');
?>

<div id="content" class="container">
    <div class="table-header-container">
        <h2 class="tabel-header">Systeem aanmaken</h2>
    </div>

    <form method="post" action="private/environment_insert.php" id="form" class="form_block form_full_length">
        <input id="test_environment_name" name="environment_name" type="text" minlength="3" maxlength="45" onkeydown="setTimeout(error_environment_name, 1500)" required/>
        </label>
        <br>
        <p id="error_environment_name" class="error_message"></p>

            <label for="customer">Gekoppelde klant</label><br>

                <?php $customer = get_customerlist() ?>
			<?php foreach ($customerlist as $customer) : ?>

                <select name="customer" id="customer" required>
                <option value="" disabled selected hidden>Kies een klant</option>
                <option value="<?=$customer->customer_id; ?>"><?=$customer->customer_name; ?></option>
            </select>



<?php endforeach; ?>

 </form>
     <div class="buttons_bottom">
                    <button class="volgende" form="form" type="submit">Volgende stap</button>
                    <button class="annuleren" onclick="window.location.href ='userlist';">Annuleren</button>
</div>


    </div>



    <!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>
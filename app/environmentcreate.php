<?php

require_once('private/path_constants.php');

$page_title = 'Omgeving aanmaken';

require_once(PRIVATE_PATH . '/functions.php');
require_once(CLASS_PATH . '/Environment.php');
require_once(PRIVATE_PATH . '/environment_functions.php');
require_once(CLASS_PATH . '/Customer.php');
require_once(PRIVATE_PATH . '/customer_functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

session_start();

// authorisatiechecks. zie authorisation_functions.php
// de eerste twee functions worden aangeroepen op elke pagina
// de derde wordt aangeroepen op alle pagina's waar alleen admins mogen komen
is_logged_in();
session_expired();

include(SHARED_PATH . '/header.php');
?>

<div id="content" class="container">
    <div class="table-header-container">
        <h2 class="tabel-header">Omgeving aanmaken</h2>
    </div>
    <div class="form_container">
    <form method="post" action="private/environment_insert.php" id="form" class="form_block form_full_length">
        <label for = "environment_name">Omgevingsnaam</label><br/>
        <input autofocus id="test_environment" name="environment_name" type="text" minlength="3" maxlength="45" onkeydown="setTimeout(error_environment_name, 1500)" required/>
        <p id="error_environment" class="error_message"></p>


        <div class="form_block form_full_length">
            <label for="customer_id">Gekoppelde klant</label><br>

                <?php $customerlist = get_customerlist() ?>


                <select name="customer_id" id="customer_id" required>
                <option value="" disabled selected hidden>Kies een klant</option>
                    <?php foreach ($customerlist as $customer) : ?>
                <option value="<?=$customer->customer_id; ?>"><?=$customer->customer_name; ?></option>
                    <?php endforeach; ?>
            </select>
        </div>




 </form>
     <div class="buttons_bottom">
                    <button class="volgende" form="form" type="submit">Volgende stap</button>
                    <button class="annuleren" onclick="window.location.href ='userlist';">Annuleren</button>
</div>


    </div>



    <!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>
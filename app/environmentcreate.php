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
		<h2 class="tabel-header">Omgeving aanmaken - Stap 1</h2>
	</div>
    <form method="get" action="relationcreate.php" id="form">
        <h2 class="basisgegevens">Basisgegevens</h2>
        <p class="uitleg">In deze stap kan je de omgeving een naam geven en koppelen aan een klant.</p>
        <div class="form_container">
            <div class="form_block form_full_length">
                <label>
                    Omgevingsnaam<br>
                    <input autofocus id="test_environment_name" name="environment_name" type="text" minlength="3" maxlength="45" onkeydown="setTimeout(error_environment_name, 1500)" required/>
                </label>
                <p id="error_environment_name" class="error_message"></p>
            </div>
            <div class="form_block form_full_length">
                <label for="customer">Gekoppelde klant</label><br>
                <select name="customer_id" id="customer" required>
                <option value="" disabled selected hidden>Kies een klant</option>
                    <?php
                    $customerlist = get_customerlist(); 
                    
                    foreach ($customerlist as $customer) :  ?>  

                    <option value="<?=$customer->customer_id; ?>"><?=$customer->customer_name; ?></option>
                        

                    
                    <?php endforeach; ?>
                    

                    
                </select>
            </div>      
        </div> 
    </form>
     <div class="buttons_bottom">
                    <button class="volgende btn-user-cancel" form="form" type="submit">Volgende</button>
                    <button class="annuleren" onclick="window.location.href ='userlist';">Annuleren</button>
</div>

<!-- Nu staat Javascript niet achteraan. Probleem? -->
<script type="text/javascript" src="private/js/environment_crud.js"></script>
<script type="text/javascript" src="private/js/modal.js"></script>

    <!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>
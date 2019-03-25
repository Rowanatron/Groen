<!-- Default PHP header -->
<?php

require_once('private/path_constants.php');

$page_title = 'Create customer';

require_once('private/functions.php');
require_once('customer_functions.php');
require_once('Customer.php');
require_once('private/authorisation_functions.php');

session_start();

// authorisatiechecks. zie authorisation_functions.php
// de eerste twee functions worden aangeroepen op elke pagina
// de derde wordt aangeroepen op alle pagina's waar alleen admins mogen komen
is_logged_in();
session_expired();
only_for_admins();

include('private/shared/header.php');
?>

<div id="content" class="container">
	<div class="table-header-container">
		<h2 class="tabel-header">Customer aanmaken</h2>
	</div>
    <form method="post" action="insert_customer.php" id="form">
        <div class="form_container">    
            <div class="form_block form_full_length">
                <label>
                    Klantnaam<br>
                    <input id="test_customer_name" name="customername" type="text" minlength="5" maxlength="45" onkeydown="setTimeout(error_customer_name, 1500)" required/>
                </label>
                <br>
                <p id="error_customer_name" class="error_message"></p>
            </div>
        </div>   
    </form>
    <div class="buttons_bottom">
        <button class="aanmaken" form="form" type="submit">Klant aanmaken</button>
        <button class="annuleren" onclick="window.location.href ='customerlist';">Annuleren</button>
    </div> 
</div>

<meta http-equiv="refresh" content="1801; public/login.php" />

<!-- Nu staat Javascript niet achteraan. Probleem? -->
<script type="text/javascript" src="CustomerJavascript.js">
</script>

<!-- Default PHP footer -->
<?php include('private/shared/footer.php')?>
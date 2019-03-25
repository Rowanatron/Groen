<!-- Default PHP header -->
<?php

require_once('private/path_constants.php');

$page_title = 'Create customer';

require_once('private/functions.php');
require_once('private/customer_functions.php');
require_once('private/class/Customer.php');
require_once('private/authorisation_functions.php');

session_start();

// authorisatiechecks. zie authorisation_functions.php
// de eerste twee functions worden aangeroepen op elke pagina
// de derde wordt aangeroepen op alle pagina's waar alleen admins mogen komen
is_logged_in();
session_expired();
only_for_admins();

include('private/shared/header.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // <link rel="stylesheet" href="/stylesheet.css">

    $customer_name = $_POST['customer_name'];
    
    // Checks
    if (empty($customer_name)){
        $message = "Alle velden moeten worden ingevuld";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    
    else if (strlen($customer_name) < 2){
        $message = "De gebruikersnaam moet minimaal 2 karakters bevatten";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    
    else {
    
    $testcustomer = get_customer_by_customer_name($customer_name);
    
    if (strtolower($testcustomer->get_customer_name()) == strtolower($customer_name)){
        $message = "Deze klantnaam bestaat al";
        echo "<script type='text/javascript'>alert('$message');</script>"; ?>
        <meta http-equiv="refresh" content="0; customercreate.php" />
        <?php
        exit();    
    }
    
    // Zet klant in database
    $customer = new Customer(0, $customer_name);
    insert_customer($customer);
    
    ?>
        <meta http-equiv="refresh" content="0; customerlist.php" />
        <?php
        exit();
    }
    
}
?>

<div id="content" class="container">
	<div class="table-header-container">
		<h2 class="tabel-header">Klant aanmaken</h2>
	</div>
    <form method="post" action="customercreate.php" id="form">
        <div class="form_container">    
            <div class="form_block form_full_length">
                <label>
                    Klantnaam<br>
                    <input autofocus id="test_customer_name" name="customer_name" type="text" minlength="2" maxlength="45" onkeydown="setTimeout(error_customer_name, 1500)" required/>
                </label>
                <br>
                <p id="error_customer_name" class="error_message"></p>
            </div>
        </div>   
    </form>
    <div class="buttons_bottom">
        <button class="aanmaken" form="form" type="submit">Klant aanmaken</button>
        <button class="annuleren" onclick="window.location.href ='customerlist.php';">Annuleren</button>
    </div> 
</div>

<meta http-equiv="refresh" content="1801; login.php" />

<!-- Nu staat Javascript niet achteraan. Probleem? -->
<script type="text/javascript" src="private/js/customer_crud.js">
</script>

<!-- Default PHP footer -->
<?php include('private/shared/footer.php')?>
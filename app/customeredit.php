<!-- Default PHP header -->
<?php

require_once('private/path_constants.php');

$page_title = 'Bewerk klant';

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/customer_functions.php');
require_once(CLASS_PATH . '/Customer.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

session_start();

is_logged_in();
session_expired();
only_for_admins();

include(SHARED_PATH . '/header.php');
if($_POST['customer_id'] == 0) {
    header("Location: customerlist.php");
} else {
$customer = get_customer_by_id($_POST['customer_id']);
}
?>

<!-- Hier komt de content -->
<div id="content" class="container">
	<div class="table-header-container">
		<h2 class="tabel-header">Klant bewerken</h2>
	</div>

    <form method="post" action="customeredit.php" id="form-edit">
        <input type=hidden name="customer_id" value="<?=$customer->customer_id; ?>"/>
        <input type=hidden name="original_customer_name" value="<?=$customer->customer_name; ?>"/>
        <div class="form_container">
            <div class="form_block form_full_length">
                <label>
                    Klantnaam<br>
                    <input id="test_customer_name" name="customer_name" type="text" minlength="2" maxlength="45" onkeydown="setTimeout(error_username, 1500)" value="<?=$customer->customer_name; ?>" required/>
                </label>
                <br>
                <p id="error_customer_name" class="error_message"></p>
            </div>      
        </div>  
    </form>
    <form style="display:none;" method="post" action="customerlist.php" id="form-delete">
		<input type="hidden" name="action" value="delete_customer" />
        <input type="hidden" name="customer_id" value="<?=$customer->customer_id; ?>"/>
        <input type="hidden" name="customer_name" value="<?=$customer->customer_name; ?>"/>
    </form>
    <div class="buttons_bottom">
        <button class="btn-user-save" form="form-edit" type="submit">Klant opslaan</button>
		<button class="btn-user-delete" id="show_modal" onclick="showModal('<?= $customer->customer_name; ?>', 'form-delete')" value="delete-customer">Klant verwijderen</button>
 <!--       <button class="btn-user-delete" form="form-delete" type="submit">Gebruiker verwijderen</button> -->
        <button class="btn-user-cancel" onclick="window.location.href = 'customerlist.php';"> Annuleren </button>
    </div>       
</div>
<div class="modal" id="modal">
	<div id="modal-content">
		<h1>Klant verwijderen</h1>
		<p>Weet u zeker dat u <span id="modal-username"></span> wilt verwijderen</p>
		<button id="modal-delete-button" form="form-delete" type="submit">Klant verwijderen</button>
		<button onClick="hideModal()">Annuleren</button>
	</div>
</div>

<!-- Nu staat Javascript niet achteraan. Probleem? -->
<script type="text/javascript" src="private/js/customer.js"></script>
<script type="text/javascript" src="private/js/modal.js"></script>

<!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>
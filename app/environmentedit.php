<?php

require_once('private/path_constants.php');

$page_title = 'Bewerk omgeving';

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/customer_functions.php');
require_once(CLASS_PATH . '/Customer.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
require_once(CLASS_PATH . '/Environment.php');
require_once(PRIVATE_PATH . '/environment_functions.php');

session_start();
is_logged_in();
session_expired();
only_for_admins();

include(SHARED_PATH . '/header.php');

if(isset($_GET['id'])) {
    $environment = get_environment_by_id($_GET['id']);
} else if (isset($_POST['environment_id'])){
    $original_environment_name = $_POST['original_environment_name'];
    $environment_id = $_POST['environment_id'];
    $environment_name = $_POST['environment_name'];
    $customer_id = $_POST['customer_id'];

    
    if ($original_environment_name != $environment_name) {
        $environment1 = get_environment_by_environment_name($environment_name);

        if(strtolower($environment1->get_environment_name()) == strtolower($environment_name)) {
            $message = "Bewerken mislukt! Deze omgevingsnaam bestaat al";
            echo "<script type='text/javascript'>alert('$message');</script>";
            ?>
            <meta http-equiv="refresh" content="0; environmentlist.php" />
            <?php
            exit();
        } else {
            $updated_environment = new Environment($environment_id, $environment_name, $customer_id);
            update_environment($updated_environment);
        }
    } else {
        $updated_environment = new Environment($environment_id, $environment_name, $customer_id);
        update_environment($updated_environment);
    }
    ?>
        <meta http-equiv="refresh" content="0; environmentlist.php" />
        <?php
        exit();
}
if (!isset($_GET['id'])) {
	header("Location: environmentlist.php");
}
?>

<div id="content" class="container">
	<div class="table-header-container">
		<h2 class="tabel-header">Omgeving bewerken</h2>
	</div>

    <form method="post" action="environmentedit.php" id="form-edit">
        <input type=hidden name="environment_id" value="<?=$environment->get_environment_id(); ?>"/>
        <input type=hidden name="original_environment_name" value="<?=$environment->get_environment_name(); ?>"/>
        <div class="form_container">
            <div class="form_block form_full_length">
                <label>
                    Omgevingsnaam<br>
                    <input id="test_environment_name" name="environment_name" type="text" minlength="2" maxlength="45" onkeydown="setTimeout(error_environment_name, 1500)" value="<?=$environment->get_environment_name(); ?>" required/>
                </label>
                <br>
                <p id="error_environment_name" class="error_message"></p>
            </div>
            <div class="form_block form_full_length">
                <label for="customer">Gekoppelde klant</label><br>
                <select name="customer_id" id="customer" required>
                    
                    <?php
                    $customerlist = get_customerlist(); 
                    
                    foreach ($customerlist as $customer) :  ?>  

                    <option <?php if ($environment->get_customer_id() == $customer->get_customer_id()) { echo "selected"; } ?> value="<?= $customer->get_customer_id()?>"><?= $customer->get_customer_name() ?></option>
                        

                    
                    <?php endforeach; ?>
                    

                    
                </select>
            </div>      
        </div>  
    </form>
    <form style="display:none;" method="post" action="environmentlist.php" id="form-delete">
		<input type="hidden" name="action" value="delete_environment" />
        <input type="hidden" name="environment_id" value="<?=$environment->get_environment_id(); ?>"/>
        <input type="hidden" name="environment_name" value="<?=$environment->get_environment_name(); ?>"/>
        <input type="hidden" name="customer_id" value="<?=$environment->get_customer_id(); ?>"/>
    </form>
    <div class="buttons_bottom">
        <button class="btn-user-save" form="form-edit" type="submit">Omgeving opslaan</button>
		<button class="btn-user-delete" id="show_modal" onclick="show_modal('<?= $environment->get_environment_name(); ?>', 'form-delete')" value="delete-environment">Omgeving verwijderen</button>
        <button class="btn-user-cancel" onclick="window.location.href = 'environmentlist.php';"> Annuleren </button>
    </div>       
</div>
<div class="modal" id="modal">
	<div id="modal-content">
		<h1>Omgeving verwijderen</h1>
		<p>Weet u zeker dat u <span id="modal-name"></span> wilt verwijderen</p>
		<button id="modal-delete-button" form="form-delete" type="submit">Omgeving verwijderen</button>
		<button onClick="hide_modal()">Annuleren</button>
	</div>
</div>

<!-- Nu staat Javascript niet achteraan. Probleem? -->
<script type="text/javascript" src="private/js/environment_crud.js"></script>
<script type="text/javascript" src="private/js/modal.js"></script>

<!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>
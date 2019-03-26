<?php

require_once('private/path_constants.php');

$page_title = 'Relaties toevoegen';

require_once(PRIVATE_PATH . '/functions.php');
require_once(CLASS_PATH . '/VirtualMachine.php');
require_once(PRIVATE_PATH . '/vm_functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
require_once (CLASS_PATH . '/DatabasePDO.php');

session_start();

// authorisatiechecks. zie authorisation_functions.php
// de eerste twee functions worden aangeroepen op elke pagina
// de derde wordt aangeroepen op alle pagina's waar alleen admins mogen komen
is_logged_in();
session_expired();

include(SHARED_PATH . '/header.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {


    $environment_id = "1";
    $vm_name_from = $_POST['vm_name_from'];
    $vm_name_to = $_POST['vm_name_to'];
    $relation_description = $_POST['relation_description'];
    $bidirectional = $_POST['bidirectional'];


    vm_relation_add($environment_id, $vm_name_from, $vm_name_to, $relation_description, $bidirectional);

}


?>



    <div id="content" class="container">
        <div class="table-header-container">
            <h2 class="tabel-header">Relaties</h2>
        </div>
        <div class="form_container">
        <div method="post" action="env_vm_relation_create.php" id="form" class="form_block form_full_length">

            <label for="vm_name_from">Machine 1</label><br>



                <select name="vm_name_from" id="vm_name_from" required>
                    <option value="" disabled selected hidden>Kies een machine</option>
                    <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>
                    <option value="<?=$vm->getName(); ?>"><?=$vm->getName(); ?></option>
                    <?php endforeach; ?>
        </select>




            <br><label for="bidirectional">Relatie</label><br>

                <select name="bidirectional" id="bidirectional" required>
                    <option value="" disabled selected hidden>Relatie</option>
                    <option value="0">enkelvoudig</option>
                    <option value="1">tweevoudig</option>
                </select>


            <br><label for="vm_name_to">Machine 2</label><br>

                <select name="vm_name_to" id="vm_name_to" required>
                    <option value="" disabled selected hidden>Kies een machine</option>
                    <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>
                        <option value="<?=$vm->getName(); ?>"><?=$vm->getName(); ?></option>
                    <?php endforeach; ?>
                </select>


            <br><label> Omschrijving<br>
                <input id="test_description" name="relation_description" type="text" maxlength="255" onkeydown="setTimeout(error_description, 1500)"/>
                <p id="error_description" class="error_message"></p>
            </label>
            <br>
        </div>
    </div>


        </form>
        <div class="buttons_bottom">
            <button class="volgende" form="form" type="submit">Opslaan</button>
            <button class="annuleren" onclick="window.location.href ='environmentlist';">Afbreken</button>
        </div>


    </div>




<?php include(SHARED_PATH . '/footer.php') ?>
<?php

require_once('private/path_constants.php');

$page_title = 'Relaties toevoegen';

require_once(PRIVATE_PATH . '/functions.php');
require_once(CLASS_PATH . '/VirtualMachine.php');
require_once(PRIVATE_PATH . '/vm_functions.php');
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
            <h2 class="tabel-header">Relaties</h2>
        </div>

        <form method="post" action="private/environment_insert.php" id="form" class="form_block form_full_length">

            <label for="vm_name_from">Machine 1</label><br>

            <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>

                <select name="vm_name_from" id="vm_name_from" required>
                    <option value="" disabled selected hidden>Kies een machine</option>
                    <option value="<?=$vm->name; ?>"><?=$vm->name; ?></option>
                </select>

            <?php endforeach; ?>


            <label for="bidirectional">Relatie</label><br>

                <select name="bidirectional" id="bidirectional" required>
                    <option value="" disabled selected hidden>Relatie</option>
                    <option value="FALSE">enkelvoudig</option>
                    <option value="TRUE">tweevoudig</option>
                </select>


            <label for="vm_name_to">Machine 2</label><br>

            <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>

                <select name="vm_name_to" id="vm_name_to" required>
                    <option value="" disabled selected hidden>Kies een machine</option>
                    <option value="<?=$vm->name; ?>"><?=$vm->name; ?></option>
                </select>

            <?php endforeach; ?>

        </form>
        <div class="buttons_bottom">
            <button class="volgende" form="form" type="submit">Opslaan</button>
            <button class="annuleren" onclick="window.location.href ='userlist';">Annuleren</button>
        </div>


    </div>




<?php include(SHARED_PATH . '/footer.php')?>
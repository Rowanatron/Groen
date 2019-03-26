<?php

require_once('private/path_constants.php');

$page_title = 'Relaties toevoegen';

require_once(PRIVATE_PATH . '/functions.php');
require_once(CLASS_PATH . '/VirtualMachine.php');
require_once(PRIVATE_PATH . '/vm_functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
require_once (CLASS_PATH . '/DatabasePDO.php');
require_once(CLASS_PATH . '/Environment.php');
require_once(PRIVATE_PATH . '/environment_functions.php');
require_once(CLASS_PATH . '/Customer.php');
require_once(PRIVATE_PATH . '/customer_functions.php');

session_start();

// authorisatiechecks. zie authorisation_functions.php
// de eerste twee functions worden aangeroepen op elke pagina
// de derde wordt aangeroepen op alle pagina's waar alleen admins mogen komen
is_logged_in();
session_expired();

include(SHARED_PATH . '/header.php');


if ($_SERVER["REQUEST_METHOD"] == "GET"){

    $environment_name = $_GET['environment_name'];
    $test_environment_name = get_environment_by_environment_name($environment_name);

    if (strtolower($test_environment_name->get_environment_name()) == strtolower($environment_name)){
        $message = "Deze omgevingsnaam bestaat al";
        echo "<script type='text/javascript'>alert('$message');</script>"; ?>
        <meta http-equiv="refresh" content="0; environmentcreate.php" />
        <?php
        exit();
    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $environment_name = $_POST['environment_name'];
    $customer_id = $_POST['customer_id'];

    $environment = new Environment(0, $environment_name, $customer_id);
    insert_environment($environment);

    $newly_created_env = get_environment_by_environment_name($environment_name);
    $environment_id = $newly_created_env->environment_id;


    $vm_name_from = $_POST['vm_name_from'];
    $vm_name_to = $_POST['vm_name_to'];
    $relation_description = $_POST['relation_description'];
    $bidirectional = $_POST['bidirectional'];


    $pdo = new DatabasePDO();
    $conn = $pdo->get();
    for ($x = 0; $x<3; $x++) {



        $data = [
            'environment_id' => $environment_id,
            'vm_name_from' => $vm_name_from[$x],
            'vm_name_to' => $vm_name_to[$x],
            'relation_description' => $relation_description[$x],
        ];


        $query = "INSERT INTO `server_monitor`.`env_vm_relation` (`environment_id`, `vm_name_from`, `vm_name_to`, `description`) VALUES (:environment_id, :vm_name_from, :vm_name_to, :relation_description);";


        try {
            $statement = $conn->prepare($query);
            $statement->execute($data);
        } catch (PDOException $e) {
            echo "Oops er ging iets mis {$e->getMessage()}";
        }

        if ($bidirectional[$x] == 1) {


            $data = [
                'environment_id' => $environment_id,
                'vm_name_from' => $vm_name_to[$x],
                'vm_name_to' => $vm_name_from[$x],
                'relation_description' => $relation_description[$x],
            ];



            try {
                $statement = $conn->prepare($query);
                $statement->execute($data);
            } catch (PDOException $e) {
                echo "Oops er ging iets mis {$e->getMessage()}";
            }


        }



    }
    ?>
    <meta http-equiv="refresh" content="0; environmentlist.php" />
    <?php
    exit();

}


?>



    <div id="content" class="container">
        <div class="table-header-container">
            <h2 class="tabel-header">Relaties</h2>
        </div> <!-- table-header-content-->
        <div class="form_container">
        <form method="post" action="env_vm_relation_create.php" id="form" class="form_block form_full_length">
            <input type="hidden" name="environment_name" value="<?= $_GET['environment_name']?>"/>
            <input type="hidden" name="customer_id" value="<?= $_GET['customer_id']?>"/>

            <div id="dynamicInput">
            <label for="vm_name_from">Machine 1</label><br>



                <select name="vm_name_from[]" id="vm_name_from" required>
                    <option value="" disabled selected hidden>Kies een machine</option>
                    <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>
                    <option value="<?=$vm->getName(); ?>"><?=$vm->getName(); ?></option>
                    <?php endforeach; ?>
        </select>




            <br><label for="bidirectional">Relatie</label><br>

                <select name="bidirectional[]" id="bidirectional" required>
                    <option value="" disabled selected hidden>Relatie</option>
                    <option value="0">enkelvoudig</option>
                    <option value="1">tweevoudig</option>
                </select>


            <br><label for="vm_name_to">Machine 2</label><br>

                <select name="vm_name_to[]" id="vm_name_to" required>
                    <option value="" disabled selected hidden>Kies een machine</option>
                    <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>
                        <option value="<?=$vm->getName(); ?>"><?=$vm->getName(); ?></option>
                    <?php endforeach; ?>
                </select>


            <br><label> Omschrijving<br>
                <input id="test_description" name="relation_description[]" type="text" maxlength="255" onkeydown="setTimeout(error_description, 1500)" value=" "/>
                <p id="error_description" class="error_message"></p>
            </label>
            <br>



        </div>
        <div id="extra_fields"></div>
    </div> <!-- form_container -->

        </form>


        <div class="buttons_bottom">
            <input type="button" value="Voeg een relatie toe" onclick="addInput('dynamicInput', 'extra_fields');">
            <button class="volgende" form="form" type="submit">Opslaan</button>
            <button class="annuleren" onclick="window.location.href ='environmentlist';">Afbreken</button>
        </div>


    </div> <!--content -->

<script>


    function addInput(divName, extra_fields){

            var newdiv = document.createElement('div');
            var delete_button = document.createElement('div');
            delete_button.innerHTML = "<input type='button' value='Verwijder deze relatie' onclick='this.parentNode.parentNode.removeChild(this.parentNode);'/>";
            newdiv.innerHTML = document.getElementById(divName).innerHTML + delete_button.innerHTML;
            document.getElementById(extra_fields).appendChild(newdiv);


    }

</script>


<?php include(SHARED_PATH . '/footer.php') ?>
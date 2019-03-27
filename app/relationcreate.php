<?php

require_once('private/path_constants.php');

$page_title = 'Relaties toevoegen';

require_once(PRIVATE_PATH . '/functions.php');
require_once(CLASS_PATH . '/VirtualMachine.php');
require_once(PRIVATE_PATH . '/vm_functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
require_once(CLASS_PATH . '/DatabasePDO.php');
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


if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $environment_name = $_GET['environment_name'];
    $test_environment_name = get_environment_by_environment_name($environment_name);

    if (strtolower($test_environment_name->get_environment_name()) == strtolower($environment_name)) {
        $message = "Deze omgevingsnaam bestaat al";
        echo "<script type='text/javascript'>alert('$message');</script>"; ?>
        <meta http-equiv="refresh" content="0; environmentcreate.php"/>
        <?php
        exit();
    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $environment_name = $_POST['environment_name'];
    $customer_id = $_POST['customer_id'];

    $customer_name = get_customer_by_id($customer_id)->customer_name;

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
    for ($x = 0; $x < 3; $x++) {


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
    <form method="get" action="systemoverview.php" id="environment_created_form">
        <input type="hidden" name="environment_name" value="<?=$environment_name?>"/>
        <input type="hidden" name="customer_name" value="<?=$customer_name?>"/>
    </form>

    <script type="text/javascript">

        function submit_environment_to_overview() {

            var form = document.getElementById("environment_created_form");

            form.submit();

        }

        window.onload = submit_environment_to_overview();

    </script>
    <?php

}

?>


    <div id="content" class="container">
        <div class="table-header-container">
            <h2 class="tabel-header">Omgeving aanmaken - Stap 2<br>Voeg relaties toe voor omgeving <?= $_GET['environment_name'] ?><br></h2>
        </div> <!-- table-header-content-->

            <form method="post" action="relationcreate.php" id="form">
                <input type="hidden" name="environment_name" value="<?= $_GET['environment_name'] ?>"/>
                <input type="hidden" name="customer_id" value="<?= $_GET['customer_id'] ?>"/>
                <div class="">
                    <div id="dynamic_input">
                        <div class="form_block">
                            <label for="vm_name_from">Machine 1</label><br>
                            <select name="vm_name_from[]" id="vm_name_from" required>
                                <option value="" disabled selected hidden>Kies een machine</option>
                                <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>
                                    <option value="<?= $vm->getName(); ?>"><?= $vm->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form_block">
                            <label for="bidirectional">Relatie</label><br>
                            <select name="bidirectional[]" id="bidirectional" required>
                                <option value="" disabled selected hidden>Relatie</option>
                                <option value="0">enkelvoudig</option>
                                <option value="1">tweevoudig</option>
                            </select>
                        </div>

                        <div class="form_block">
                            <label for="vm_name_to">Machine 2</label><br>
                            <select name="vm_name_to[]" id="vm_name_to" required>
                                <option value="" disabled selected hidden>Kies een machine</option>
                                <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>
                                    <option value="<?= $vm->getName(); ?>"><?= $vm->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form_block form_full_length">
                            <label> Omschrijving<br>
                                <textarea id="test_description" rows = "5" cols = "50" name = "relation_description[]" onkeydown="setTimeout(error_description, 1500)"></textarea>
<!--                                <input id="test_description" name="relation_description[]" type="text" maxlength="255"-->
<!--                                       onkeydown="setTimeout(error_description, 1500)" value=" "/>-->
                                <p id="error_description" class="error_message"></p>
                            </label>
                        </div>
                    </div> <!-- end dynamic input -->

                    <div id="extra_fields">
                    </div>
                </div> <!-- form_container -->
                <div id="add-relationship-btn">
                    <a class="volgende" onclick="add_input('dynamic_input', 'extra_fields');">
                        <i class="material-icons table-icons">add</i><span>Voeg een relatie toe</span>
                    </a>
                </div>
            </form>





        <div class="buttons_bottom">

            <button class="aanmaken" form="form" type="submit">Opslaan</button>
            <button class="annuleren" onclick="window.location.href ='environmentlist';">Annuleren</button>
            <button class="volgende" onclick="window.location.href ='environmentcreate';">Vorige</button>

        </div>


    </div> <!--content -->

    <script>


        function add_input(div_name, extra_fields) {

            var new_div = document.createElement('div');
            var delete_button = document.createElement('div');
            delete_button.innerHTML = "<input id='del-relationship-btn' type='button' value='Verwijder deze relatie' onclick='this.parentNode.parentNode.removeChild(this.parentNode);'/>";
            new_div.innerHTML = document.getElementById(div_name).innerHTML + delete_button.innerHTML;
            document.getElementById(extra_fields).appendChild(new_div);


        }

    </script>


<?php include(SHARED_PATH . '/footer.php') ?>
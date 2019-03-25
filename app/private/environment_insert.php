<?php


$page_title = 'Create user';

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/Environment.php');
require_once(PRIVATE_PATH . '/environment_functions.php');
require_once(PRIVATE_PATH . '/Customer.php');
require_once(PRIVATE_PATH . '/customer_functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

session_start();

// authorisatiechecks. zie authorisation_functions.php
// de eerste twee functions worden aangeroepen op elke pagina
// de derde wordt aangeroepen op alle pagina's waar alleen admins mogen komen
is_logged_in();
session_expired();
only_for_admins();

$environment_name = $_POST['environment_name'];
$customer_id = $_POST['customer_id'];


// Checks
if (empty($environment_name) || empty($customer_id)) {
    $message = "Alle velden moeten worden ingevuld";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else if (strlen($environment_name) < 3){
    $message = "De omgevingsnaam moet minimaal 3 karakters bevatten";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else {

    $test_environment_name = get_environment_by_environmentname($environment_name);

    if (strtolower($test_environment_name->get_environement_name()) == strtolower($environment_name)){
        $message = "Deze omgevingsnaam bestaat al";
        echo "<script type='text/javascript'>alert('$message');</script>"; ?>
        <meta http-equiv="refresh" content="0; ../environment_create.php" />
        <?php
        exit();
    }


// Zet omgeving in database
    $environment = new Environment($environment_name, $customer_id);
    insert_environment($environment);

    ?>
    <meta http-equiv="refresh" content="0; ../env_mv_relation_create.php" />
    <?php
    exit();
}

?>

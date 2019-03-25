<link rel="stylesheet" href="/stylesheet.css">

<?php

require_once('path_constants.php');
require_once(PRIVATE_PATH . '/user_functions.php');
require_once(CLASS_PATH . '/User.php');

$username = $_POST['username'];
$password = $_POST['password'];
$repeat_password = $_POST['repeat_password'];
$given_name = $_POST['given_name'];
$family_name = $_POST['family_name'];
$email = $_POST['email'];
$role = $_POST['role'];

// Checks
if (empty($username) || empty($password) || empty($repeat_password) || empty($given_name) || empty($family_name) || empty($email) || empty($role)){
    $message = "Alle velden moeten worden ingevuld";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else if (strlen($username) < 5){
    $message = "De gebruikersnaam moet minimaal 5 karakters bevatten";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else if (strlen($password) < 8 || 0 === preg_match('~[A-Z]~', $password)  || 0 === preg_match('~[0-9]~', $password) || 0 === preg_match('~[a-z]~', $password)) {
    $message = "Wachtwoord moet minimaal 8 karakters bevatten, waarvan 1 hoofdletter, 1 kleine letter en 1 getal";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else if ($password!= $repeat_password) {
    $message = "De wachtwoorden komen niet overeen";
    echo "<script type='text/javascript'>alert('$message');</script>";
 }

else if (strlen($given_name) < 2){
    $message = "De voornaam moet minimaal 2 karakters bevatten";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else if (strlen($family_name) < 2){
    $message = "De achternaam moet minimaal 2 karakters bevatten";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else {

$testuser = get_user_by_username($username);

if (strtolower($testuser->get_username()) == strtolower($username)){
    $message = "Deze gebruikersnaam bestaat al";
    echo "<script type='text/javascript'>alert('$message');</script>"; ?>
    <meta http-equiv="refresh" content="0; ../usercreate.php" />
    <?php
    exit();    
}

// Password hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Zet user in database
$user = new User(0, $username, $hashed_password, $given_name, $family_name, $email, $role);
insert_user($user);

?>
    <meta http-equiv="refresh" content="0; ../userlist.php" />
    <?php
    exit();
}

?>

<link rel="stylesheet" href="/stylesheet.css">

<?php
require_once('../private/path_constants.php');
require_once(PRIVATE_PATH . '/user_functions.php');
require_once(PRIVATE_PATH . '/User.php');

$original_username = $_POST['original_username'];
$user_id = $_POST['user_id'];
$username = $_POST['username'];
$password = $_POST['password'];
$repeat_password = $_POST['repeat_password'];
$given_name = $_POST['given_name'];
$family_name = $_POST['family_name'];
$email = $_POST['email'];
$role = $_POST['role'];

if ($original_username != $username) {
    $user = get_user_by_username($username);

    if (strtolower($user->get_username()) == strtolower($username)){
        $message = "Bewerken mislukt! Deze gebruikersnaam bestaat al";
        echo "<script type='text/javascript'>alert('$message');</script>";
        ?>
        <meta http-equiv="refresh" content="0; ../public/userlist.php" />
        <?php
        exit();
    }
}

if ($password == null) {
    $user_from_database = get_user_by_id($user_id);
    $updated_user = new User($user_id, $username, $user_from_database->get_password(), $given_name, $family_name, $email, $role);
    update_user($updated_user);
?>
        <meta http-equiv="refresh" content="0; ../public/userlist.php" />
        <?php
        exit();
} 

else if (strlen($password) < 8 || 0 === preg_match('~[A-Z]~', $password)  || 0 === preg_match('~[0-9]~', $password) || 0 === preg_match('~[a-z]~', $password)) {
    $message = "Bewerken mislukt! Wachtwoord moet minimaal 8 karakters bevatten, waarvan 1 hoofdletter, 1 kleine letter en 1 getal";
    echo "<script type='text/javascript'>alert('$message');</script>";
    ?>
        <meta http-equiv="refresh" content="0; ../public/userlist.php" />
        <?php
        exit();
} 

else if ($password != $repeat_password) {
    $message = "wachtwoord was niet gelijk, bewerken mislukt";
    echo "<script type='text/javascript'>alert('$message');</script>";
    ?>
        <meta http-equiv="refresh" content="0; ../public/userlist.php" />
        <?php
        exit();
 } 
 
 else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $updated_user_with_password = new User($user_id, $username, $hashed_password, $given_name, $family_name, $email, $role);
    update_user($updated_user_with_password);
 }

?>
    <meta http-equiv="refresh" content="0; ../public/userlist.php" />
    <?php
    exit();

?>
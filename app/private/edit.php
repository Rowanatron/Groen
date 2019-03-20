<link rel="stylesheet" href="/stylesheet.css">

<?php

include_once("DatabasePDO.php");

$databasePDOInstance = new DatabasePDO();

$conn = $databasePDOInstance->get();



if ($_POST['original_username'] != $_POST['username']) {

    $query = "SELECT `username` FROM server_monitor.user;";

try{
    $statement = $conn->prepare($query);
    $statement->execute();
        } catch(PDOException $e) {
    echo "oops {$e->getMessage()}";
    }

    while($usernamelist = $statement->fetch(PDO::FETCH_ASSOC)){

        if (strtolower($usernamelist['username']) == strtolower($_POST['username'])){
        $message = "Bewerken mislukt! Deze gebruikersnaam bestaat al";
        echo "<script type='text/javascript'>alert('$message');</script>";
        ?>
        
        <meta http-equiv="refresh" content="1; ../public/userlist.php" />
        <?php
        exit();
        }
    }
}

if ($_POST['password'] == null) {

$data = [
    'user_id' => $_POST['user_id'],
    'username' => $_POST['username'],
    'given_name' => $_POST['given_name'],
    'family_name' => $_POST['family_name'],
    'email' => $_POST['email'],
    'role' => $_POST['role']
];

var_dump($data['user_id']);

$query = "UPDATE user SET `username` = :username, `given_name` = :given_name, `family_name` = :family_name, `email` = :email, `role` = :role 
WHERE (`user_id` = :user_id);";

try{
    $statement = $conn->prepare($query);
    $statement->execute($data);
} catch(PDOException $e) {
    echo "Oops er ging iets mis {$e->getMessage()}";
}

?>
        
        <meta http-equiv="refresh" content="1; ../public/userlist.php" />
        <?php
        exit();

}

else {

$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$data = [
    'user_id' => $_POST['user_id'],
    'username' => $_POST['username'],
    'password' => $hashed_password,
    'given_name' => $_POST['given_name'],
    'family_name' => $_POST['family_name'],
    'email' => $_POST['email'],
    'role' => $_POST['role']
    
];

if (strlen($_POST['password']) < 8 || 0 === preg_match('~[A-Z]~', $_POST['password'])  || 0 === preg_match('~[0-9]~', $_POST['password']) || 0 === preg_match('~[a-z]~', $_POST['password'])) {
    $message = "Bewerken mislukt! Wachtwoord moet minimaal 8 karakters bevatten, waarvan 1 hoofdletter, 1 kleine letter en 1 getal";
    echo "<script type='text/javascript'>alert('$message');</script>";
    ?>
        
        <meta http-equiv="refresh" content="2; ../public/userlist.php" />
        <?php
        exit();

}

else if ($_POST['password']!= $_POST['repeat_password']) {
    $message = "wachtwoord was niet gelijk, bewerken mislukt";
    echo "<script type='text/javascript'>alert('$message');</script>";
    ?>
        
        <meta http-equiv="refresh" content="2; ../public/userlist.php" />
        <?php
        exit();
 }

else {
    
    $query = "UPDATE user SET `password` = :password,`username` = :username, `given_name` = :given_name, `family_name` = :family_name, `email` = :email, `role` = :role 
    WHERE (`user_id` = :user_id);";

try{
    $statement = $conn->prepare($query);
    $statement->execute($data);
} catch(PDOException $e) {
    echo "Oops er ging iets mis {$e->getMessage()}";
}

?>
        
        <meta http-equiv="refresh" content="2; ../public/userlist.php" />
        <?php
        exit();

}
}

?>
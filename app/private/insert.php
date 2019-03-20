<link rel="stylesheet" href="/stylesheet.css">

<?php

include_once("DatabasePDO.php");

$databasePDOInstance = new DatabasePDO();

$conn = $databasePDOInstance->get();

$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$data = [
    'username' => $_POST['username'],
    'password' => $hashed_password,
    'given_name' => $_POST['given_name'],
    'family_name' => $_POST['family_name'],
    'email' => $_POST['email'],
    'role' => $_POST['role']
    
];

if (empty($data['username']) || empty($data['password']) || empty($_POST['repeat_password']) ||empty($data['given_name']) ||empty($data['family_name']) ||empty($data['email']) || empty($data['role'])){
    $message = "alle velden moeten worden ingevuld";
    echo "<script type='text/javascript'>alert('$message');</script>";
}


else if (strlen($data['username']) < 5){
    $message = "gebruikersnaam moet minstens 5 letters zijn";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else if (strlen($data['password']) < 8 || 0 === preg_match('~[A-Z]~', $data['password'])  || 0 === preg_match('~[0-9]~', $data['password']) || 0 === preg_match('~[a-z]~', $data['password'])) {
    $message = "Wachtwoord moet minimaal 8 karakters bevatten, waarvan 1 hoofdletter, 1 kleine letter en 1 getal";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else if ($_POST['password']!= $_POST['repeat_password']) {
    $message = "wachtwoord was niet gelijk";
    echo "<script type='text/javascript'>alert('$message');</script>";
 }

else if (strlen($data['given_name']) < 2){
    $message = "voornaam moet minstens 2 letters zijn";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else if (strlen($data['family_name']) < 2){
    $message = "achternaam moet minstens 2 letters zijn";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else{

    $query = "SELECT `username` FROM server_monitor.user;";

try{
    $statement = $conn->prepare($query);
    $statement->execute();
        } catch(PDOException $e) {
    echo "oops {$e->getMessage()}";
    }

    while($usernamelist = $statement->fetch(PDO::FETCH_ASSOC)){

        if (strtolower($usernamelist['username']) == strtolower($data['username'])){
        $message = "Deze gebruikersnaam bestaat al";
        echo "<script type='text/javascript'>alert('$message');</script>";
        ?>
        
        <meta http-equiv="refresh" content="2; ../public/createuser.php" />
        <?php
        exit();
        }
    }


    
$query = "INSERT INTO user (`username`,`password`,`given_name`,`family_name`,`email`, `role`)
VALUES(:username, :password, :given_name, :family_name, :email, :role);";

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

?>

Je wordt na 2 seconden omgeleid
<meta http-equiv="refresh" content="2; ../public/createuser.php" />
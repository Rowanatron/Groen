<link rel="stylesheet" href="/stylesheet.css">

<?php

include_once("DatabasePDO.php");

$databasePDOInstance = new DatabasePDO();

$conn = $databasePDOInstance->get();

$data = [
    'username' => $_POST['username'],
    'password' => $_POST['password'],
    'givenname' => $_POST['givenname'],
    'familyname' => $_POST['familyname'],
    'email' => $_POST['email'],
    'role' => $_POST['role']
    
];

if (empty($data['username']) || empty($data['password']) || empty($_POST['repeatpassword']) ||empty($data['givenname']) ||empty($data['familyname']) ||empty($data['email']) || empty($data['role'])){
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

else if ($data['password']!= $_POST['repeatpassword']) {
    $message = "wachtwoord was niet gelijk";
    echo "<script type='text/javascript'>alert('$message');</script>";
 }

else if (strlen($data['givenname']) < 2){
    $message = "voornaam moet minstens 2 letters zijn";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else if (strlen($data['familyname']) < 2){
    $message = "achternaam moet minstens 2 letters zijn";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

else{

    $query = "SELECT `username` FROM users.userlist";

try{
    $statement = $conn->prepare($query);
    $statement->execute();
        } catch(PDOException $e) {
    echo "oops {$e->getMessage()}";
    }

    while($usernamelist = $statement->fetch(PDO::FETCH_ASSOC)){

        if ($usernamelist == $data['username']){
        $message = "gebruikersnaam is al in gebruik, kies een andere";
        echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

    
$query = "INSERT INTO users.userlist (`username`,`password`,`givenname`,`familyname`,`email`, `role`)
VALUES(:username, :password, :givenname, :familyname, :email, :role);";

try{
    $statement = $conn->prepare($query);
    $statement->execute($data);
} catch(PDOException $e) {
    echo "Oops er ging iets mis {$e->getMessage()}";
}

 }

?>

Je wordt na 13 seconden omgeleid
<meta http-equiv="refresh" content="13; ./voeggebruikertoe.html" />

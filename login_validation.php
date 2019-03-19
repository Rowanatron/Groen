<?php

include_once("app/private/DatabasePDO.php");

$databasePDOInstance = new DatabasePDO();

$conn = $databasePDOInstance->get();

$username_from_post = isset($_POST['username']) ? $_POST['username'] : false;
$password_from_post = isset($_POST['password']) ? $_POST['password'] : false;

// SQL injection prevention in.
// Validator gebruiken.

if ($username_from_post && $password_from_post){
  
    $query = "SELECT * FROM userlist WHERE username = '$username_from_post' AND password = '$password_from_post';";

    try {
        $statement = $conn->prepare($query);
        $statement->execute();    
    } catch(PDOException $e){
        echo "Error: {$e->getMessage()}";
    }
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    
    if (!$result){
        echo 'Onbekende combinatie van gebruikersnaam en wachtwoord. Redirect naar loginscherm';
    } else {
        header("Location: app/public/systemoverview.php");
    }
} else {
    echo "Vul alle velden in. Redirect naar loginscherm.";
}

 ?>
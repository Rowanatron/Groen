<?php

include_once("private/DatabasePDO.php");

// session_start();
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     header("Location: public/systemoverview.php");
// }

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $databasePDOInstance = new DatabasePDO();

    $conn = $databasePDOInstance->get();

    $username_from_post = isset($_POST['username']) ? $_POST['username'] : false;
    $password_from_post = isset($_POST['password']) ? $_POST['password'] : false;

    // SQL injection prevention in.
    // Validator gebruiken.
    if ($username_from_post && $password_from_post){
    
        $query = "SELECT * FROM users WHERE username = '$username_from_post' AND password = '$password_from_post';";

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
            header("Location: public/systemoverview.php");
        }
    } else {
        echo "Vul alle velden in. Redirect naar loginscherm.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <h1>Server Monitor</h1>
    <form method="POST" action="login.php">
        Gebruikersnaam:<br>
        <input type="text" name="username">
        <br>
        Wachtwoord:<br>
        <input type="password" name="password">
        <br><br>
        <input type="submit" value="Inloggen">
      </form> 
    
</body>
</html>
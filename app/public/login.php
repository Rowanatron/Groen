<?php

require_once('../private/pathConstants.php');
require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/userfunctions.php');
require_once(PRIVATE_PATH . '/User.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

session_start();

$page_title = 'Log in';

if(isset($_SESSION["message"])){
    $message = $_SESSION["message"];
    session_destroy();
}


skip_login_page();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = isset($_POST['username']) ? $_POST['username'] : false;
    $password = isset($_POST['password']) ? $_POST['password'] : false;

    if ($username && $password) {
        $user = get_user_by_username($username);

        $hashed_password = $user->get_password();
        $valid_password = password_verify($password, $hashed_password);

        if ($valid_password) {
            $_SESSION["loggedin"] = true;
            $_SESSION["StartSession"] = time();
            // $_SESSION["id"] = $id;
            if ($user->get_role() === "admin") {
                $_SESSION["isAdmin"] = true;
            }
            header("Location: systemoverview.php");
        } else {
            $message = 'Onbekende combinatie van gebruikersnaam en wachtwoord.';
        }
    } else {
        $message = 'Vul alle velden in.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" media="all" href="css/login.css">
    <title>Login</title>
</head>

<body>
    <div id="content">
        <div id="logobox">
            <img src="img/logo.jpg" alt="Logo">
        </div>
        <form method="POST" action="login.php">
            <fieldset>
                <label>
                    Gebruikersnaam
                    <input type="text" name="username">
                </label>
            </fieldset>
            <fieldset>
                <label>
                    Wachtwoord
                    <input type="password" name="password">
                </label>
            </fieldset>
            <div class="errormsg">
                <?php echo isset($message) ? $message : '' ?>
            </div>
            <fieldset class="submit_field">
                <input type="submit" value="Inloggen">
            </fieldset>
        </form>
    </div>
</body>

</html> 
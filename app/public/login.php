<?php

include_once("../private/DatabasePDO.php");
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && (time() - $_SESSION["StartSession"] < 3600)){
    header("Location: systemoverview.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $databasePDOInstance = new DatabasePDO();

    $conn = $databasePDOInstance->get();

    $username_from_post = isset($_POST['username']) ? $_POST['username'] : false;
    $password_from_post = isset($_POST['password']) ? $_POST['password'] : false;

    if ($username_from_post && $password_from_post) {
        $query = "SELECT * FROM userlist WHERE username = :username";

        try {
            $statement = $conn->prepare($query);
            $statement->execute(array('username' => $username_from_post));
        } catch (PDOException $e) {
            echo "Error: {$e->getMessage()}";
        }

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $hashed_password = $result["password"];
        $valid_password = password_verify($password_from_post, $hashed_password);

        if ($valid_password) {
            $_SESSION["loggedin"] = true;
            $_SESSION["StartSession"] = time();
            // $_SESSION["id"] = $id;
            if ($result["role"] === "admin") {
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
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="css/styles_login.css">
=======
    <link rel="stylesheet" media="all" href="css/login.css">
>>>>>>> bfb9aede2e065a3ffc42b4dc25f5d43a0066691e
    <title>Login</title>
</head>

<body>
<<<<<<< HEAD
    <div class="menu centered">
        <img class="logo" src="img/logo.jpg" alt="Logo">
=======
    <div id="content">
		<div id="logobox">
				<img src="img/logo.jpg" alt="Logo">
		</div>
>>>>>>> bfb9aede2e065a3ffc42b4dc25f5d43a0066691e
        <form method="POST" action="login.php">
            <p>
				<label>
					Gebruikersnaam
					<input type="text" name="username">
				</label>
            </p>
            <p>
                <label>
					Wachtwoord
					<input type="password" name="password">
				</label>
			</p>
            <div class="errormsg">
				<?php echo isset($message) ? $message : ''?>
            </div>
			<p class="submitp">
				<input type="submit" value="Inloggen">
			</p>
        </form>
    </div>
</body>

</html> 
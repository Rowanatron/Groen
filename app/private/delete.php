<?php

include_once("DatabasePDO.php");

$databasePDOInstance = new DatabasePDO();

$conn = $databasePDOInstance->get();

$user_id = $_POST['user_id'];
$username = $_POST['username'];

    $query = "DELETE FROM user WHERE (`user_id` = :user_id);";

try{
    $statement = $conn->prepare($query);
    $statement->execute(array('user_id' => $user_id));
        } catch(PDOException $e) {
    echo "oops {$e->getMessage()}";
    }

        $message = "Gebruiker $username verwijderd";
        echo "<script type='text/javascript'>alert('$message');</script>";
        ?>
        
        <meta http-equiv="refresh" content="1; ../public/userlist.php" />


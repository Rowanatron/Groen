<?php

include_once("app/private/DatabasePDO.php");

$databasePDOInstance = new DatabasePDO();

$conn = $databasePDOInstance->get();

echo "hallo";

// $data = [
//     'username' => $_POST['username'],
//     'password' => $_POST['password'],
// ];

// $query = "SELECT * FROM users 
// WHERE username=':username' AND password=':password';";

// try{
//     $statement = $conn->prepare($query);
//     $statement->execute($data);
//     $result = $statement;
//     // if (empty($result)){
//     //     echo "failed";
//     // } else {
//     //     echo "succes";
//     // }
// } catch (PDOException $e) {
//     echo "Error: {$e->getMessage()}";
// }

?>
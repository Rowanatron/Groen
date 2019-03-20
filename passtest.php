<?php
$password = 'welkom';

echo $password . '<br>';

$beveiligde_password = password_hash($password, PASSWORD_DEFAULT);

var_dump($beveiligde_password);

// $nietdegoedewachtwoord = 'welkom1';

// $geverifieerd = password_verify($password, $beveiligde_password);

// echo $geverifieerd;

// // vanaf hier

// include_once("app/private/DatabasePDO.php");

// $databasePDOInstance = new DatabasePDO();

// $conn = $databasePDOInstance->get();

// $usernamevar = 'hash6';

// $data = [
// 'username' => $usernamevar,
// 'password' => $beveiligde_password, // welkom
// 'givenname' => 'hash1',
// 'familyname' => 'hashachternaam',
// 'email' => 'email',
// 'role' => 'user'
// ];

// $query = "INSERT INTO users.userlist (`username`,`password`,`givenname`,`familyname`,`email`, `role`)
// VALUES(:username, :password, :givenname, :familyname, :email, :role);" ;

// try{
//     $statement = $conn->prepare($query);
//     $statement->execute($data); 
// } catch(PDOException $e) {
//     echo "Oops er ging iets mis {$e->getMessage()}";
// } 

// // ERuithalen en verifieren

// $query = "SELECT * FROM userlist WHERE username = :username";

// try {
//     $statement = $conn->prepare($query);
//     $statement->execute(array('username' => $usernamevar));
// } catch (PDOException $e) {
//     echo "Error: {$e->getMessage()}";
// }
// $result = $statement->fetch(PDO::FETCH_ASSOC);
// var_dump($result);

// $hashed_password = $result["password"];
// $valid_password = password_verify($password, $hashed_password);

// echo 'DIT MOET TRUE ZIJN: ';
// var_dump($valid_password);



?>

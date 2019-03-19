<?php
$password = 'welkom';

echo $password;

$beveiligde_password = password_hash($password, PASSWORD_DEFAULT);

var_dump($beveiligde_password);

$nietdegoedewachtwoord = 'welkom1';

$geverifieerd = password_verify($password, $beveiligde_password);

echo $geverifieerd;

?>
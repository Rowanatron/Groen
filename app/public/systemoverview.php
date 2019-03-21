<?php

require_once('../private/pathConstants.php');
require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/userfunctions.php');
require_once(PRIVATE_PATH . '/User.php'); // waarom?
require_once(PRIVATE_PATH . '/authorisation_functions.php');

$page_title = 'System overview';

session_start();

is_logged_in();
session_expired();

include(SHARED_PATH . '/header.php');
// $welkom = 'Welkom, ' .$_SESSION["given_name"]. '. ';

if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];
}

?>

<!-- Hier komt de content -->
<div id="content" class="container">
 <?php 
//  echo $welkom;
 echo isset($message) ? $message : '';
 unset($_SESSION['message']);
 ?>

  
</div>

<?php include(SHARED_PATH . '/footer.php')?>
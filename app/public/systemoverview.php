<?php

require_once('../private/pathConstants.php');
require_once('../private/functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

$page_title = 'Systemoverview';
$page = "systemoverview";

session_start();
is_logged_in();
session_expired();

include(SHARED_PATH . '/header.php');

if(isset($_SESSION[message])){
    $message = $_SESSION[message];}

?>
<div id="content" class="container">

 <!-- Hier komt de content -->
 <?php if(isset($_SESSION["isAdmin"])) : ?>
 Hallo, adminnetje
 <?php else : ?>
 Hallo, groepsapi
 <?php endif; ?>
 <?php echo isset($message) ? $message : '' ?>

  
</div>

<?php include(SHARED_PATH . '/footer.php')?>
<?php

session_start();

if(time() - $_SESSION["StartSession"] > 3600){
    // errormessage dat sessie verlopen is
    unset($_SESSION);
    session_destroy();
    header("Location: login.php");
}

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("Location: login.php");
}

require_once('../private/pathConstants.php');

$page_title = 'System overview';
$page = "systemoverview";

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/userfunctions.php');
require_once(PRIVATE_PATH . '/User.php');

include(SHARED_PATH . '/header.php');

?>

<!-- Hier komt de content -->
<div id="content" class="container">
 <?php if(isset($_SESSION["isAdmin"])) : ?>
 Hallo, adminnetje
 <?php else : ?>
 Hallo, groepsapi
 <?php endif; ?>
  
</div>

<?php include(SHARED_PATH . '/footer.php')?>
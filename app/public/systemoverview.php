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
require_once('../private/functions.php');

$page_title = 'Systemoverview';
$page = "systemoverview";
include(SHARED_PATH . '/header.php');
?>
<div id="content" class="container">

 <!-- Hier komt de content -->
 <?php if(isset($_SESSION["isAdmin"])) : ?>
 Hallo, adminnetje
 <?php else : ?>
 Hallo, groepsapi
 <?php endif; ?>
  
</div>

<?php include(SHARED_PATH . '/footer.php')?>
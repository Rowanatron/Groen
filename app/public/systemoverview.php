<?php

session_start();

if(time() - $_SESSION["StartSession"] > 3600){
    // errormessage dat sessie verlopen is
    session_destroy();
    header("Location: ../login.php");
}

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    if(isset($_SESSION["isAdmin"])){
        // header("Location: systemoverview.php"); redirect naar Adminversie maken!
        echo "Hallo, adminnetje";
    } else {
        // header("Location: systemoverview.php"); redirect naar Userversie maken!
        echo "Hallo, usertje";
    }
    
} else {
    // errormessage dat de bezoeker hier niet zomaar mag komen!
    
    header("Location: ../login.php");
}

require_once('../private/pathConstants.php');
require_once('../private/functions.php');


$page_title = 'Systemoverview';
include(SHARED_PATH . '/header.php');
?>
<div id="content" class="container">

 <!-- Hier komt de content -->
  
</div>

<?php include(SHARED_PATH . '/footer.php')?>


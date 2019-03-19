<?php
session_start();
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


require_once('../private/initialize.php');

$page_title = 'Systemoverview';
include(SHARED_PATH . '/header.php');



?>
<div id="content">
 <!-- Hier komt de content -->
</div>

<?php include(SHARED_PATH . '/footer.php')?>


<?php 
          session_start();
          session_destroy();
          session_start();
          $_SESSION["message"] = "U bent succesvol uitgelogd.";
          header("Location: ../public/login.php");
?>
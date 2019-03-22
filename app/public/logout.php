<?php 
          session_start();
          session_destroy();
          session_start();
          $_SESSION["logout_message"] = "U bent succesvol uitgelogd.";
          header("Location: login");
?>
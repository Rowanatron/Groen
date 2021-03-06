<?php

require_once(CLASS_PATH . '/User.php');

function is_logged_in () {
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
        session_destroy();
        session_start();
        $_SESSION["message"] = "Eerst inloggen aub!";
        header("Location: login");
        exit();
    } else {
        return true;
    }
}

function session_expired () {
    if(time() - $_SESSION["start_session"] > 1800){
        session_destroy();
        session_start();
        $_SESSION["message"] = "Sessie verlopen. Log opnieuw in.";
        header("Location: login");
        exit();
    } else {
        $_SESSION["start_session"] = time();
        return false;
    }
}

function only_for_admins () {
    $user = $_SESSION["user"];
    if (!($user->get_role() === "admin")) {

        // $_SESSION["message"] = "Je bent niet bevoegd om de opgevraagde pagina te bezoeken.";
        header("Location: systemoverview");
    } else { 
        return true;    
    }
}

function skip_login_page() {
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true && (time() - $_SESSION["start_session"] < 3600)) {
        header("Location: systemoverview");
    }
}


?>
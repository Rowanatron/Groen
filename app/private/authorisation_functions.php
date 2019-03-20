<?php


function is_logged_in () {
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
        session_destroy();
        session_start();
        $_SESSION["message"] = "Eerst inloggen aub!";
        header("Location: login.php");
        exit();
    } else {
        return true;
    }
}

function session_expired () {
    if(time() - $_SESSION["StartSession"] > 3600){
        session_destroy();
        session_start();
        $_SESSION["message"] = "Sessie verlopen. Log opnieuw in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION["StartSession"] = time();
        return false;
    }
}

function only_for_admins () {
    if (!isset($_SESSION["isAdmin"])){
        $_SESSION["message"] = "Je hebt geen toegang tot deze pagina, omdat je geen admin-rechten hebt.";
        header("Location: systemoverview.php");
    } else { 
        return true;    
    }
}

function skip_login_page() {
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && (time() - $_SESSION["StartSession"] < 3600)) {
        header("Location: systemoverview.php");
    }
}


?>
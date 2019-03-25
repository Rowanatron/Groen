<?php

function edit_user($new_user, $repeat_password) {
	require_once('path_constants.php');
	require_once(PRIVATE_PATH . '/user_functions.php');
	require_once(CLASS_PATH . '/User.php');
	
	// Get current user
	$current_user = get_user_by_id($new_user->get_user_id());

	// If username has changed
	if(strtolower($new_user->get_username()) != strtolower($current_user->get_username())) {
		
		//Check if username already exists
		 if (username_exists($new_user->get_username())) {
			$message = "Bewerken mislukt! Deze gebruikersnaam bestaat al";
		echo "<script type='text/javascript'>alert('$message');</script>";
			return -1;			
		}
	}
	
	// If password has not changed
	if ($new_user->get_password() == null) {
		$new_user->set_password($current_user->get_password());
		update_user($new_user);
		header('Location: userlist');
	}

	// If password not right characters
	else if (strlen($new_user->get_password()) < 8 || 0 === preg_match('~[A-Z]~', $new_user->get_password())  || 0 === preg_match('~[0-9]~', $new_user->get_password()) || 0 === preg_match('~[a-z]~', $new_user->get_password())) {
		$message = "Bewerken mislukt! Wachtwoord moet minimaal 8 karakters bevatten, waarvan 1 hoofdletter, 1 kleine letter en 1 getal";
		echo "<script type='text/javascript'>alert('$message');</script>";
	} 
	
	// If passwords do not match
	else if ($new_user->get_password() != $repeat_password) {
		$message = "Wachtwoord was niet gelijk, bewerken mislukt";
		echo "<script type='text/javascript'>alert('$message');</script>";
	} 
	
	
	// Else hash new password
	else {
		$hashed_password = password_hash($new_user->get_password(), PASSWORD_DEFAULT);
		$new_user->set_password($hashed_password);
		update_user($new_user);
		header('Location: userlist');
	}

}

?>
<?php

function edit_user($new_user) {
	require_once('path_constants.php');
	require_once(PRIVATE_PATH . '/user_functions.php');
	require_once(CLASS_PATH . '/User.php');
	
	$prev_user = get_user_by_id($new_user->get_user_id());
	

	if (strtolower($new_user->get_username()) != strtolower($prev_user->get_username())) {
		$check_username = get_user_by_username($new_user->get_username());

		if (strtolower($check_username->get_username()) == strtolower($new_user->get_username())){
			$message = "Bewerken mislukt! Deze gebruikersnaam bestaat al";
			echo "<script type='text/javascript'>alert('$message');</script>";
			return -1;
		}
	}

	if ($password == null) {
		$user_from_database = get_user_by_id($user_id);
		$updated_user = new User($user_id, $username, $user_from_database->get_password(), $given_name, $family_name, $email, $role);
		update_user($updated_user);
	?>
			<meta http-equiv="refresh" content="0; ../userlist" />
			<?php
			exit();
	} 

	else if (strlen($password) < 8 || 0 === preg_match('~[A-Z]~', $password)  || 0 === preg_match('~[0-9]~', $password) || 0 === preg_match('~[a-z]~', $password)) {
		$message = "Bewerken mislukt! Wachtwoord moet minimaal 8 karakters bevatten, waarvan 1 hoofdletter, 1 kleine letter en 1 getal";
		echo "<script type='text/javascript'>alert('$message');</script>";
		?>
			<meta http-equiv="refresh" content="0; ../userlist" />
			<?php
			exit();
	} 

	else if ($password != $repeat_password) {
		$message = "wachtwoord was niet gelijk, bewerken mislukt";
		echo "<script type='text/javascript'>alert('$message');</script>";
		?>
			<meta http-equiv="refresh" content="0; ../userlist" />
			<?php
			exit();
	 } 
	 
	 else {
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$updated_user_with_password = new User($user_id, $username, $hashed_password, $given_name, $family_name, $email, $role);
		update_user($updated_user_with_password);
	 }
	 
	header('Location: userlist');

}

?>
<?php
//// POST REQUEST

if (isset($_POST['username'])) {
	
	// Check ingevulde gegevens compleet
	
	// Username
	if (empty($_POST['username'])) {
		array_push($page_errors, "Gebruikersnaam is leeg.");
		$empty_value = true;
	} else if (username_exists($_POST['username']) && (!$is_edit || (isset($_POST['id']) && $_POST['username'] != get_username_by_user_id($_POST['id'])))) {
		array_push($page_errors, "Deze gebruikersnaam bestaat al.");	
	} else if (!$is_admin && $_POST['username'] != $session_user->get_username()) {
		array_push($page_errors, "Als gebruiker mag je de gebruikersnaam niet wijzigen.");
		$empty_value = true;
	} else if (strlen($_POST['username']) < 5) {
		array_push($page_errors, "De gebruikersnaam moet minimaal 5 karakters bevatten");
		$empty_value = true;
	} else if (strlen($_POST['username']) > 45) {
		array_push($page_errors, "De gebruikersnaam mag maximaal 45 karakters bevatten");
		$empty_value = true;
	} else {
		$post_username = $_POST['username'];
	}
	
	// Voornaam
	if (empty($_POST['given_name'])) {
		array_push($page_errors, "Voornaam is leeg.");
		$empty_value = true;
	} else if (strlen($_POST['given_name']) < 2) {
		array_push($page_errors, "De voornaam moet minimaal 2 karakters bevatten");
		$empty_value = true;
	} else if (strlen($_POST['given_name']) > 45) {
		array_push($page_errors, "De voornaam mag maximaal 45 karakters bevatten");
		$empty_value = true;
	} else {
		$post_given_name = $_POST['given_name'];
	}
	
	// Achternaam
	if (empty($_POST['family_name'])) {
		array_push($page_errors, "Achternaam is leeg.");
		$empty_value = true;
	} else if (strlen($_POST['family_name']) < 2) {
		array_push($page_errors, "De achternaam moet minimaal 2 karakters bevatten");
		$empty_value = true;
	} else if (strlen($_POST['family_name']) > 45) {
		array_push($page_errors, "De achternaam mag maximaal 45 karakters bevatten");
		$empty_value = true;
	} else {
		$post_family_name = $_POST['family_name'];
	}
	
	// Email
	if (empty($_POST['email'])) {
		array_push($page_errors, "E-mail is leeg.");
		$empty_value = true;		
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		array_push($page_errors, "Dit is geen geldig emailadres");
		$empty_value = true;
	} else {
		$post_email = $_POST['email'];
	}
	
	// Rol
	if (empty($_POST['role'])) {
		array_push($page_errors, "Rol is leeg.");
		$empty_value = true;
	} else if (!$is_admin && $_POST['role'] == "admin") {
		array_push($page_errors, "Je bent niet bevoegd je rol te veranderen.");
		$empty_value = true;		
	} else if (!$is_admin) {
		$post_role = "user";
	} else if ($_POST['role'] != "admin" && $_POST['role'] != "user") {
		array_push($page_errors, "Dit is geen geldige rol.");
		$empty_value = true;
	} else {
		$post_role = $_POST['role'];
	}
	
	// Check wachtwoord
	if (!empty($_POST['password'])) {
		
		if($_POST['password'] != $_POST['password_repeat']) {
			array_push($page_errors, "Wachtwoorden komen niet overeen.");
			$empty_value = true;
		} else if (strlen($_POST['password']) < 8 || preg_match('~[A-Z]~', $_POST['password']) == 0 || preg_match('~[0-9]~', $_POST['password']) == 0 || preg_match('~[a-z]~', $_POST['password']) == 0) {
			array_push($page_errors, "Het wachtwoord moet minimaal 8 karakters bevatten waarvan 1 hoofdletter, 1 kleine letter en 1 getal.");
			$empty_value = true;
		} else {
			$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		}
		
	} else if (!$is_edit) {
		array_push($page_errors, "Wachtwoord is leeg.");
		$empty_value = true;
	}
	
	// Check id
	if ($is_edit) {
		if (!isset($_POST['id']) || empty($_POST['id'])) {
			array_push($page_errors, "Wachtwoord is leeg.");
			$empty_value = true;
		} else if (!$is_admin && $_POST['id'] != $session_user->get_user_id()) {
			array_push($page_errors, "Je hebt geen bevoegheid deze gebruiker te wijzigen.");
			$empty_value = true;
		} else if ($_POST['id'] != $get_id) {
			array_push($page_errors, "Gebruiker en data komen niet overeen.");
			$empty_value = true;
		} else {
			$post_id = $_POST['id'];
		}
	}
	
	// Create user object to input in database
	$post_user = new User(null, (isset($post_username) ? $post_username : null), null, (isset($post_given_name) ? $post_given_name : null), (isset($post_family_name) ? $post_family_name : null), (isset($post_email) ? $post_email : null), (isset($post_role) ? $post_role : null));
	
	if (!isset($empty_value)) {
		
		if (isset($hashed_password)) {
			$post_user->set_password($hashed_password);
		}
		if (isset($post_id)) {
			$post_user->set_user_id($post_id);
		}
		if (isset($img_filename)) {
			$post_user->set_img($img_filename);
		}
		
		// Put in database
		if (!$is_edit) {
			$result = insert_user($post_user);

		} else {
			$result = custom_update_user($post_user);
		}
		
		// Check for errors, if succeeded continue to upload image
		if (empty($result)) {
			$new_id = get_user_id_by_username($post_user->get_username());
			$post_user->set_user_id($new_id);
			
			// Check for image
			if ($_FILES['img']['size'] > 0) {
				// Upload file
				$img_filename = upload_img('img', $post_user->get_user_id());
				// Check if upload succeeded
				if ($img_filename == false) {
					array_push($page_errors, "Gebruiker is aangemaakt, maar het uploaden van een afbeelding is mislukt. Voeg deze eventueel nu nog toe.");
					$is_edit = true;
					$get_id = $post_user->get_user_id();
				} else {
					$post_user->set_img($img_filename);
					$result = update_user_img($post_user);
					if (isset($result)) {
						array_push($page_errors, $result);
						$is_edit = true;
						$get_id = $post_user->get_user_id();
					}
				}
			}
		} else {
			array_push($page_errors, $result);	
		}
		
		if (sizeof($page_errors) == 0) {
			header("Location: " . ($is_admin? userlist : systemoverview));
		}
	}

}

?>
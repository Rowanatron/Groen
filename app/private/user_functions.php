<?php

require_once 'path_constants.php';

require_once(CLASS_PATH . '/DatabasePDO.php');
require_once(CLASS_PATH . '/User.php');

function get_userlist() {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM user ORDER BY username;";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute();
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$userArray = array();
	
	while($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$user = new User($row['user_id'], $row['username'], $row['password'], $row['given_name'], $row['family_name'], $row['email'], $row['role']);
		$user->set_img($row['img']);
		array_push($userArray, $user);
	}
	
	return $userArray;
}

function get_user_by_username($username) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM user WHERE username = :username";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('username' => $username));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	
	$user = new User($row['user_id'], $row['username'], $row['password'], $row['given_name'], $row['family_name'], $row['email'], $row['role'], $row['img']);
	$user->set_img($row['img']);
	return $user;
}

function username_exists($username) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM user WHERE username = :username";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('username' => $username));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	
	if ($row['username'] == $username) {
		return true;
	}
	return false;
}

function get_user_by_id($user_id) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM user WHERE user_id = :user_id";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('user_id' => $user_id));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	
	$user = new User($row['user_id'], $row['username'], $row['password'], $row['given_name'], $row['family_name'], $row['email'], $row['role'], $row['img']);
	
	return $user;
}

function get_user_id_by_username($username) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	
	$query = "SELECT user_id FROM user WHERE username = :username";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('username' => $username));
	} catch (PDOException $e) {
		return false;
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
		
	return $row['user_id'];
}

function get_username_by_user_id($user_id) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	
	$query = "SELECT username FROM user WHERE user_id = :user_id";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('user_id' => $user_id));
	} catch (PDOException $e) {
		return false;
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
		
	return $row['username'];
}

function delete_user($user_id) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "DELETE FROM user WHERE user_id = :user_id";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('user_id' => $user_id));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
}

function insert_user($user){
	$pdo = new DatabasePDO();
	$conn = $pdo->get();

	$data = [
		'username' => $user->get_username(),
		'password' => $user->get_password(),
		'given_name' => $user->get_given_name(),
		'family_name' => $user->get_family_name(),
		'email' => $user->get_email(),
		'role' => $user->get_role()
	];
	  
	$query = "INSERT INTO user (`username`,`password`,`given_name`,`family_name`,`email`, `role`)
	VALUES(:username, :password, :given_name, :family_name, :email, :role);";

	try{
		$statement = $conn->prepare($query);
		$statement->execute($data);
	} catch(PDOException $e) {
		return "Error: {$e->getMessage()}";
	}
}

function update_user($user){
	$pdo = new DatabasePDO();
	$conn = $pdo->get();

	$data = [
		'user_id' => $user->get_user_id(),
		'username' => $user->get_username(),
		'password' => $user->get_password(),
		'given_name' => $user->get_given_name(),
		'family_name' => $user->get_family_name(),
		'email' => $user->get_email(),
		'role' => $user->get_role()
	];

	$query = "UPDATE user SET `username` = :username, `password` = :password, `given_name` = :given_name, `family_name` = :family_name, `email` = :email, `role` = :role 
	WHERE (`user_id` = :user_id);";

	try{
		$statement = $conn->prepare($query);
		$statement->execute($data);
	} catch(PDOException $e) {
		echo "Oops er ging iets mis {$e->getMessage()}";
	}
}

function custom_update_user($user){
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	
	$data = [
		'user_id' => $user->get_user_id(),
		'username' => $user->get_username(),
		'given_name' => $user->get_given_name(),
		'family_name' => $user->get_family_name(),
		'email' => $user->get_email(),
		'role' => $user->get_role()
	];
	
	if ($user->get_password() != null) {
		$data['password'] = $user->get_password();
	}
	
	$query = "UPDATE user SET `username` = :username, " . (empty($user->get_password()) ? "" : "`password` = :password, ") . "`given_name` = :given_name, `family_name` = :family_name, `email` = :email, `role` = :role 
	WHERE (`user_id` = :user_id);";

	try{
		$statement = $conn->prepare($query);
		$statement->execute($data);
	} catch(PDOException $e) {
		return "Error: {$e->getMessage()}";
	}
}

function update_user_img($user){
	$pdo = new DatabasePDO();
	$conn = $pdo->get();

	$data = [
		'user_id' => $user->get_user_id(),
		'img' => $user->get_img()
	];

	$query = "UPDATE user SET `img` = :img WHERE (`user_id` = :user_id);";

	try{
		$statement = $conn->prepare($query);
		$statement->execute($data);
	} catch(PDOException $e) {
		return "Error: {$e->getMessage()}";
	}
}




?>
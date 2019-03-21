<?php

include_once 'DatabasePDO.php';
include_once 'User.php';

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
	
	$user = new User($row['user_id'], $row['username'], $row['password'], $row['given_name'], $row['family_name'], $row['email'], $row['role']);
	
	return $user;
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
	
	$user = new User($row['user_id'], $row['username'], $row['password'], $row['given_name'], $row['family_name'], $row['email'], $row['role']);
	
	return $user;
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

?>
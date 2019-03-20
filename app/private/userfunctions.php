<?php

include_once 'DatabasePDO.php';
include_once 'User.php';

function getUserList() {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM userlist ORDER BY username;";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute();
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$userArray = array();
	
	while($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$user = new User($row['username'], $row['password'], $row['givenname'], $row['familyname'], $row['email'], $row['role']);
		array_push($userArray, $user);
	}
	
	return $userArray;
}

function getUserByUsername($username) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM userlist WHERE username = :username";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('username' => $username));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	
	$user = new User($row['username'], $row['password'], $row['givenname'], $row['familyname'], $row['email'], $row['role']);
	
	return $user;
}

?>
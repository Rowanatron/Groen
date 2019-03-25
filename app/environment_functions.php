<?php

include_once 'DatabasePDO.php';
include_once 'Environment.php';
include_once 'user_function.php';

function get_environmentlist() {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM environment ORDER BY environment_name;";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute();
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$environment_array = array();
	
	while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $customer_name = get_user_by_id($row['customer_id']);
		$environment = new Environment($row['environment_id'], $row['environment_name'], $customer_name);
		array_push($environment_array, $environment);
	}
	
	return $environment_array;
}
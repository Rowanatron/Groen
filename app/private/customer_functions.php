<?php

include_once 'class/DatabasePDO.php';
include_once 'class/Customer.php';
include_once 'environment_functions.php';

function get_customerlist() {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM customer ORDER BY customer_name;";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute();
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$customerArray = array();
	
	while($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$customer = new Customer($row['customer_id'], $row['customer_name']);
		array_push($customerArray, $customer);
	}
	
	return $customerArray;
}

function get_customer_by_customer_name($customer_name) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM customer WHERE customer_name = :customer_name";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('customer_name' => $customer_name));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	
	$customer = new Customer($row['customer_id'], $row['customer_name']);
	
	return $customer;
}

function get_customer_by_id($customer_id) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM customer WHERE customer_id = :customer_id";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('customer_id' => $customer_id));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	
	$customer = new Customer($row['customer_id'], $row['customer_name']);
	
	return $customer;
}

function delete_customer($customer_id) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "DELETE FROM customer WHERE customer_id = :customer_id";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('customer_id' => $customer_id));
		if (isset($_SESSION['customer_name'])){
			unset($_SESSION['customer_name']);
		}
		if (isset($_SESSION['environment_name'])){
			unset($_SESSION['environment_name']);
		}
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
}

function insert_customer($customer){
	$pdo = new DatabasePDO();
	$conn = $pdo->get();

	$data = [
		'customer_name' => $customer->get_customer_name()
	];
	  
	$query = "INSERT INTO customer (`customer_name`)
	VALUES(:customer_name);";

	try{
		$statement = $conn->prepare($query);
		$statement->execute($data);
		
		
	} catch(PDOException $e) {
		echo "Oops er ging iets mis {$e->getMessage()}";
	}
}

function update_customer($customer){
	$pdo = new DatabasePDO();
	$conn = $pdo->get();

	$data = [
		'customer_id' => $customer->get_customer_id(),
		'customer_name' => $customer->get_customer_name()
	];

	$query = "UPDATE customer SET `customer_name` = :customer_name
	WHERE (`customer_id` = :customer_id);";

	try{
		$statement = $conn->prepare($query);
		$statement->execute($data);
		if(customer_has_environment($customer)){
			$_SESSION['customer_name'] = $customer->get_customer_name();
		}
		
	} catch(PDOException $e) {
		echo "Oops er ging iets mis {$e->getMessage()}";
	}
}

?>
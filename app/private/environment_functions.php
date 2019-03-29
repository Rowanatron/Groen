<?php

require_once('path_constants.php');

require_once(CLASS_PATH . '/DatabasePDO.php');
require_once(CLASS_PATH . '/Environment.php');


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
        // $customer_name = get_customer_by_id($row['customer_id']);
		$environment = new Environment($row['environment_id'], $row['environment_name'], $row['customer_id']);
		array_push($environment_array, $environment);
	}
	
	return $environment_array;
}

function get_environment_name_from_customer_id($customer_id){

    $pdo = new DatabasePDO();
    $conn = $pdo->get();
    $query = "SELECT environment_name FROM environment WHERE customer_id = :customer_id;";


    try {
        $statement = $conn->prepare($query);
        $statement->execute(array('customer_id' => $customer_id));
    } catch (PDOException $e) {
        echo "Connection failed: {$e->getMessage()}";
    }

    $environment_array = array();

    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        // $customer_name = get_customer_by_id($row['customer_id']);
        $environment = new Environment($row['environment_id'], $row['environment_name'], $row['customer_id']);
        array_push($environment_array, $environment);
    }

    return $environment_array[0];

}


function get_environment_by_environment_name($environment_name) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM environment WHERE environment_name = :environment_name";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('environment_name' => $environment_name));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	
	$environment = new Environment($row['environment_id'], $row['environment_name'], $row['customer_id']);
	
	return $environment;
}

function get_environment_by_id($environment_id) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "SELECT * FROM environment WHERE environment_id = :environment_id";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('environment_id' => $environment_id));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
	
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	
	$environment = new Environment($row['environment_id'], $row['environment_name'], $row['customer_id']);
	
	return $environment;
}

function delete_environment($environment_id) {
	$pdo = new DatabasePDO();
	$conn = $pdo->get();
	$query = "DELETE FROM environment WHERE environment_id = :environment_id";
	
	try {
		$statement = $conn->prepare($query);
		$statement->execute(array('environment_id' => $environment_id));
	} catch (PDOException $e) {
		echo "Connection failed: {$e->getMessage()}";
	}
}

function insert_environment($environment){
	$pdo = new DatabasePDO();
	$conn = $pdo->get();

	$data = [
		'environment_name' => $environment->get_environment_name(),
		'customer_id' => $environment->get_customer_id()
	];
	  
	$query = "INSERT INTO environment (`environment_name`,`customer_id`)
	VALUES(:environment_name, :customer_id);";

	try{
		$statement = $conn->prepare($query);
		$statement->execute($data);
	} catch(PDOException $e) {
		echo "Oops er ging iets mis {$e->getMessage()}";
	}
}

function update_environment($environment){
	$pdo = new DatabasePDO();
	$conn = $pdo->get();

	$data = [
		'environment_id' => $environment->get_environment_id(),
		'environment_name' => $environment->get_environment_name(),
		'customer_id' => $environment->get_customer_id()
	];
	  
	$query = "UPDATE environment SET `environment_name` = :environment_name, `customer_id` = :customer_id 
	WHERE (`environment_id` = :environment_id);";

	try{
		$statement = $conn->prepare($query);
		$statement->execute($data);
	} catch(PDOException $e) {
		echo "Oops er ging iets mis {$e->getMessage()}";
	}
}

function customer_has_environment($customer){
    $customer_has_environment = false;
    foreach (get_environmentlist() as $environment){
        if ($environment->get_customer_id() == $customer->get_customer_id()){
            $customer_has_environment = true;
        }
    }
    return $customer_has_environment;
}

function get_relations_by_environment_id($environment_id){

    $pdo = new DatabasePDO();
    $conn = $pdo->get();

    $data = [
        'environment_id' => $environment_id,
    ];

    $query = "SELECT * FROM `env_vm_relation` WHERE (`environment_id` = :environment_id);";

    try{
        $statement = $conn->prepare($query);
        $statement->execute($data);
    } catch(PDOException $e) {
        echo "Oops er ging iets mis {$e->getMessage()}";
    }

    $relation_array = array();

    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $relation = new Relation($row['relation_id'], $row['environment_id'], $row['vm_name_from'], $row['vm_name_to'], $row['description']);
        array_push($relation_array, $relation);
    }

    return $relation_array;

}



<?php

class DatabasePDO {

    private $username;
    private $password;
    private $schema;
    private $driver;
    private $host;
	
	public function __construct() {
		require('../dbconfig.php');
		$this->username = $username;
		$this->password = $password;
		$this->schema = $schema;
		$this->driver = $driver;
		$this->host = $host;		
	}
    
    public function get(){
        $dsn = "{$this->driver}:dbname={$this->schema};host={$this->host}";
        
        try{
            $conn = new PDO($dsn, $this->username, $this->password);
             return $conn;
        } catch(PDOExcenption $e) {
            echo "Fuck deze shit ik ga naar huis: {$e->getMessage()}";
        }
        
    }
    
}

?>

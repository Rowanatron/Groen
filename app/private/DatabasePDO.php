<?php

class DatabasePDO {
    
    private $username = 'groen';
    private $password = 'groenww';
    private $schema = 'users';
    private $driver = 'mysql';
    private $host = 'localhost:3307';
    
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
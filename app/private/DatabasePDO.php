<?php

class DatabasePDO {
    
    private $username = 'code';
    private $password = '123456';
    private $schema = 'userlist';
    private $driver = 'mysql';
    private $host = 'localhost:3306';
    
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

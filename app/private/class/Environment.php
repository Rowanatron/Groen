<?php
class Environment
{
    var $environment_id;
    var $environment_name;
    var $customer_id; 

    function Environment()
    { }

    function __construct($environment_id, $environment_name, $customer_id)
    {
        $this->environment_id = $environment_id;
        $this->environment_name = $environment_name;
        $this->customer_id = $customer_id;
    }

    function set_environment_id($new_environment_id){
        $this->environment_id = $new_environment_id;
    }
    
    function get_environment_id(){
        return $this->environment_id;
    }

    function set_environment_name($new_environment_name){
        $this->environment_name = $new_environment_name;
    }
    
    function get_environment_name(){
        return $this->environment_name;
    }

    function set_customer_id($new_customer_id){
        $this->customer_id = $new_customer_id;
    }
    
    function get_customer_id(){
        return $this->customer_id;
    }

}



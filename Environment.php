<?php
class Environment
{
    var $environment_id;
    var $environment_name;
    var $customer_name; 

    function Environment()
    { }

    function __construct($environment_id, $environment_name, $customer_id)
    {
        $this->environment_id = $environment_id;
        $this->environment_name = $environment_name;
        $this->customer_id = $customer_id;
    }
}


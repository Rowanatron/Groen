<?php
class Customer {
    var $customer_id;
    var $customer_name;

function Customer(){
}

function __construct($i, $n){
    $this->customer_id=$i;
    $this->customer_name=$n;
}

function set_customer_id($new_customer_id){
    $this->customer_id = $new_customer_id;
}

function get_customer_id(){
    return $this->customer_id;
}

function set_customer_name($new_customer_name){
    $this->customer_name = $new_customer_name;
}

function get_customer_name(){
    return $this->customer_name;
}
}
?>
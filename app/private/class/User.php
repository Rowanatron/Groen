<?php
class User {
    var $user_id;
    var $username;
    var $password;
    var $given_name;
    var $family_name;
    var $email;
    var $role;

function User(){
}

function __construct($i, $u, $p, $g, $f, $e, $r){
    $this->user_id=$i;
    $this->username=$u;
    $this->password=$p;
    $this->given_name=$g;
    $this->family_name=$f;
    $this->email=$e;
    $this->role=$r;
}

function set_user_id($new_user_id){
    $this->user_id = $new_user_id;
}

function get_user_id(){
    return $this->user_id;
}

function set_username($new_username){
    $this->username = $new_username;
}

function get_username(){
    return $this->username;
}

function set_password($new_password){
    $this->password = $new_password;
}

function get_password(){
    return $this->password;
}

function set_given_name($new_given_name){
    $this->given_name = $new_given_name;
}

function get_given_name(){
    return $this->given_name;
}

function set_family_name($new_family_name){
    $this->family_name = $new_family_name;
}

function get_family_name(){
    return $this->family_name;
}

function set_email($new_email){
    $this->email = $new_email;
}

function get_email(){
    return $this->email;
}
function set_role($new_role){
    $this->role = $new_role;
}
function get_role(){
    return $this->role;
}
}
?>
<?php
class User {
    var $username;
    var $password;
    var $givenname;
    var $familyname;
    var $email;
    var $role;

function User(){
}

function __construct($u, $p, $g, $f, $e, $a){
    $this->username=$u;
    $this->password=$p;
    $this->givenname=$g;
    $this->familyname=$f;
    $this->email=$e;
    $this->admin=$a;
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

function set_givenname($new_givenname){
    $this->givenname = $new_givenname;
}

function get_givenname(){
    return $this->givenname;
}

function set_familyname($new_familyname){
    $this->familyname = $new_familyname;
}

function get_familyname(){
    return $this->familyname;
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
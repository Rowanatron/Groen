<?php
class User {
    var $username;
    function set_username($new_username){
        $this->username = $new_username;
    }
    function get_username(){
        return $this->username;
    }
    var $password;
    var $givenname;
    var $familyname;
    var $email;
    var $admin;

}
?>
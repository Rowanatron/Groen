<?php

class ApiConnector{

    private $username;
    private $password;
    private $url;

    public function __construct(){
        require(PRIVATE_PATH . '/apiconfig.php');
        $this->username = $username;
        $this->password = $password;
        $this->url = $url;
    }

    public function get_data(){
        $ch = curl_init();

        $options = array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $this->username . ":" . $this->password
        );

        curl_setopt_array($ch, $options);

        $output = curl_exec($ch);
        
        $data = (array)json_decode($output);

        curl_close($ch);

        return $data;
    }
}
 
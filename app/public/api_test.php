<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

   <?php 
        require_once('../private/pathConstants.php');

        $page_title = 'System overview';
        $page = "systemoverview";
        
        require_once(PRIVATE_PATH . '/functions.php');
        require_once(PRIVATE_PATH . '/userfunctions.php');
        require_once(PRIVATE_PATH . '/User.php');
        
        include(SHARED_PATH . '/header.php');
   ?>

    <table border="1">  
        <tr>
            <th>HostSystem</th>
            <th>customer</th>
            <th>disk_size</th>
            <th>env</th>
            <th>latency</th>
            <th>memory</th>
            <th>name</th>
            <th>omgeving</th>
            <th>vCPU</th>
        </tr>

    <?php

    // phpinfo();

    $username = 'makeitwork';
    $password = 'itWorkMake2018';

    // create curl resource
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, "https://makeitwork.local.mybit.nl:8443/vms/klanty/testing");

    // return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // set password
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

    $output = curl_exec($ch);

    // var_dump($output);

    $data = json_decode($output);

    // var_dump($data);

    curl_close($ch);

    // outut data

    foreach($data as $row){ ?>

        <tr>
            <td>
                <?php echo $row->HostSystem; ?>
            </td>
            <td>
                <?php echo $row->customer; ?>
            </td>
            <td>
                <?php echo $row->disk_size; ?>
            </td>
            <td>
                <?php echo $row->env; ?>
            </td>
            <td>
                <?php echo $row->latency; ?>
            </td>
            <td>
                <?php echo $row->memory; ?>
            </td>
            <td>
                <?php echo $row->name; ?>
            </td>
            <td>
                <?php echo $row->omgeving; ?>
            </td>
            <td>
                <?php echo $row->vCPU; ?>
            </td>
        </tr>
    
        <?php
    }
    ?>


</body>

</html> 

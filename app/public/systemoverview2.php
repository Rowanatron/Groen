    <?php 
    require_once('../private/pathConstants.php');

    $page_title = 'System overview';
    $page = "systemoverview";

    require_once(PRIVATE_PATH . '/functions.php');
    require_once(PRIVATE_PATH . '/userfunctions.php');
    require_once(PRIVATE_PATH . '/User.php');

    include(SHARED_PATH . '/header.php');


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


    // Servers opslaaan als objecten
    require_once(PRIVATE_PATH . '/VirtualMachine.php');

    $virtual_machine_list = array();

    foreach($data as $row){
        $virtual_machine = new VirtualMachine($row->HostSystem, $row->customer, $row->disk_size, 
        $row->env, $row->latency, $row->memory, $row->name, $row->omgeving, $row->vCPU);
        $virtual_machine_list[$row->name] = $virtual_machine;
    }

    ksort($virtual_machine_list);

    ?>

    <div id="content" class="container">
        <div class="system-overview-header-container">
            <h1>Systeem Overzicht</h1>
        </div>
        <div class="system-overview-servers-container">
            <?php foreach ($virtual_machine_list as $vm) : ?>
            
            <?php
                if($vm->getLatency() > 1.45) {
                    $image = "vm_red.png";
                } else if ($vm->getLatency() < 1.2){
                    $image = "vm_green.png";
                } else {
                    $image = "vm_orange.png";
                }
            ?>

            <div id="server">
                <div class="server-img">
                    <img src="<?php echo "img/" . $image?>" alt="logo van virtuele machine">
                </div>
                <div class="server-info">
                    <div class="server-name">
                        <span><?php echo $vm->getName(); ?></span>
                    </div>
                    <div class="server-info-top">
                        <span>Latency:</span>
                        <span><?php echo $vm->getLatency(); ?></span>
                        <span>Memory:</span>
                        <span><?php echo $vm->getMemory(); ?></span>
                    </div>
                    <div class="server-info-bottom">
                        <span>Storage:</span>
                        <span><?php echo $vm->getDiskSize(); ?></span>
                        <span>vCPU:</span>
                        <span><?php echo $vm->getVCPU(); ?></span>
                    </div>
                </div>    
            </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php include(SHARED_PATH . '/footer.php'); ?>
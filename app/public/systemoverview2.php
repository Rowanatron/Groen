    <?php 
    require_once('../private/path_constants.php');

    $page_title = 'System overview';
        $page = "systemoverview";

    require_once(PRIVATE_PATH . '/functions.php');
    require_once(PRIVATE_PATH . '/user_functions.php');
    require_once(PRIVATE_PATH . '/User.php');
    require_once(PRIVATE_PATH . '/vm_functions.php');

    include_once(SHARED_PATH . '/header.php');
    ?>

    <div id="content" class="container">
        <div class="system-overview-header-container">
            <h1>Systeem Overzicht</h1>
        </div>
        <div class="system-overview-servers-container">
            <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>

            <?php
            if ($vm->getLatency() > 1.45) {
                $image = "vm_red.png";
            } else if ($vm->getLatency() < 1.2) {
                $image = "vm_green.png";
            } else {
                $image = "vm_orange.png";
            }
            ?>

            <div id="server">
                <div class="server-img">
                    <img src="<?php echo "img/" . $image ?>" alt="logo van virtuele machine">
                </div>
                <div class="server-info">
                    <div class="server-name">
                        <div><?php echo $vm->getName(); ?></div>
                    </div>
                    <div class="server-info-top">
                        <div class="key-value">
                            <div class="key">Latency:</div>
                            <div class="value"><?php echo $vm->getLatency(); ?></div>
                        </div>
                        <div class="key-value">
                            <div class="key">Memory:</div>
                            <div class="value"><?php echo $vm->getMemory(); ?></div>
                        </div>
                    </div>
                    <div class="server-info-bottom">
                        <div class="key-value">
                            <div class="key">Storage:</div>
                            <div class="value"><?php echo round($vm->getDiskSize(),2); ?></div>
                        </div>
                        <div class="key-value">
                            <div class="key">vCPU:</div>
                            <div class="value"><?php echo $vm->getVCPU(); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include(SHARED_PATH . '/footer.php'); ?> 
<?php

require_once('private/path_constants.php');
require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/user_functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
require_once(PRIVATE_PATH . '/vm_functions.php');
require_once(PRIVATE_PATH . '/customer_functions.php');
require_once(PRIVATE_PATH . '/environment_functions.php');

$page_title = 'System overview';

session_start();

session_expired();
is_logged_in();

include(SHARED_PATH . '/header.php');
//$welkom = 'Welkom, ' .$_SESSION["given_name"]. '. ';

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}

?>

<!-- Message aan gebruiker -->
<div id="message-area" class='container'>
    <?php
    // echo $welkom;
    echo isset($message) ? $message : '';
    unset($_SESSION['message']);
    ?>
</div>

<!-- Hier komt de content -->
<div id="content" class="container">

    <div class="system-overview-header-container">
        <h1>Systeem overzicht</h1>
        <div id="dropdown">
            <div class="dropdown-element">
                <form method="post">
                    <h2>Klant</h2>
                    <select name="klant" onchange="this.form.submit();">
                        <?php foreach (get_customerlist() as $customer) {

                            if (customer_has_environment($customer)) {

                                $customer_name = $customer->get_customer_name();
                                $selected = '';

                                if (isset($_POST['klant'])) {
                                    if ($_POST['klant'] == $customer_name) {
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    }
                                }

                                ?>

                                <option value="<?= $customer_name ?>" <?= $selected ?>><?= $customer->get_customer_name() ?></option>

                            <?php }

                        } ?>
                    </select>
                </form>
            </div>
            <div class="dropdown-element">
                <h2>Omgeving</h2>
                <select name="omgeving" id="omgeving" required>
                    <?php
                    foreach (get_environmentlist() as $environment) : ?>

                        <?php if (isset($_POST['klant'])) {

                            if ($environment->get_customer_id() == get_customer_by_customer_name($_POST['klant'])->get_customer_id()) { ?>

                                <option value="<?= $environment->get_environment_name() ?>"> <?php echo $environment->get_environment_name() ?></option>

                            <?php }
                        } else { // TODO schrijf de else statement!!?>

                            <option value="<?= $environment->get_environment_name() ?>"> <?php echo $environment->get_environment_name() ?></option>

                       <?php } ?>

                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!--    <div>-->
    <!--        --><?php
    //        $selectOption = $_POST['klant'];
    //        var_dump($selectOption);
    //        ?>
    <!--    </div>-->

    <div class="system-overview-servers-container">
        <div id="reload-content">
            <div class="progress-bar">
                <span class="progress-bar-fill" style="width: 0%"></span>
            </div>
            <div class="desc">
                <span>Ververst elke 10 seconden</span>
            </div>

            <?php foreach (get_sorted_virtualmachine_list_with_relations() as $vm) : ?>

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
                                <div class="value"><?php echo $vm->getLatency(); ?> sec</div>
                            </div>
                            <div class="key-value">
                                <div class="key">Memory:</div>
                                <div class="value"><?php echo $vm->getMemory(); ?> GB</div>
                            </div>
                        </div>
                        <div class="server-info-bottom">
                            <div class="key-value">
                                <div class="key">Storage:</div>
                                <div class="value"><?php echo round($vm->getDiskSize(), 1); ?> GB</div>
                            </div>
                            <div class="key-value">
                                <div class="key">vCPU:</div>
                                <div class="value"><?php echo $vm->getVCPU(); ?></div>
                            </div>
                        </div>
                    </div>
                    <div id="relations">
                        <?php foreach ($vm->getRelationList() as $relation): ?>
                            <ul>
                                <li><?php echo $relation->getVmNameFrom(); ?></li>
                                <li><?php echo $relation->getVmNameTo(); ?></li>
                                <li><?php echo $relation->getDescription(); ?></li>
                            </ul>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<<<<<<< HEAD

<?php foreach (get_sorted_virtualmachine_list_with_relations() as $vm) : ?>
    <div class="modal" id="modal-<?php echo $vm->getName(); ?>">
        <div id="modal-content">

            <div id="modal-title">
                <p>Servernaam:</p>
                <h1><?php echo $vm->getName(); ?></h1></div>
            <div id="IN-left">
                <i class="material-icons table-icons arrow">arrow_upward</i>
                <?php foreach ($vm->getRelationList() as $relation): ?>
                    <div class="tooltip item">
                        <div><?php echo $relation->getVmNameFrom(); ?></div>
                        <span class="tooltiptext"><?php echo $relation->getDescription(); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="OUT-right">
                <i class="material-icons table-icons arrow">arrow_downward</i>
                <?php foreach ($vm->getRelationList() as $relation): ?>
                    <div class="tooltip item">
                        <div><?php echo $relation->getVmNameTo();?></div>
                        <span class="tooltiptext"><?php echo $relation->getDescription(); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="close-modal">
                <a onClick="hide_modal() class="close-modal"">
                    <i class="material-icons table-icons">close</i>
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>









=======
>>>>>>> e3e94d458826289892963752c8b74ca1e661ad7c
<!--Auto-refresh van het virtual machine overzicht -->
<script type="text/javascript" src="private/js/systemoverview.js"></script>

<?php include(SHARED_PATH . '/footer.php') ?> 
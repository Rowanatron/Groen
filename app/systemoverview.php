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


$er_is_tenminste_een_klant_met_een_relatie = false;

foreach (get_customerlist() as $customer) {
    if (customer_has_environment($customer)) {
        $er_is_tenminste_een_klant_met_een_relatie = true;
    }
}

if ($er_is_tenminste_een_klant_met_een_relatie) { ?>

    <!-- Hier komt de content -->
    <div id="content" class="container">

        <div class="system-overview-header-container">
            <h1>Systeem overzicht</h1>


            <div id="dropdown">
                <div class="so-dropdown-element">
                    <form class="so-form" method="get">
                        <label class="so-label" for="customer_name">Klant</label>
                        <select id="sys-overview" name="customer_name" onchange="this.form.submit();">
                            <?php

                            $selected_customer = '';
                            $selected_environment = '';

                            foreach (get_customerlist() as $customer) {

                                if (customer_has_environment($customer)) {

                                    $customer_name = $customer->get_customer_name();
                                    $selected = '';

                                    /**
                                     * Als de customer_name in de get zit wordt deze in een session gezet en selected.
                                     * Als de customer_name in de session zit wordt deze selected.
                                     */
                                    if (isset($_GET['customer_name'])) {
                                        if ($_GET['customer_name'] == $customer_name) {
                                            $_SESSION['customer_name'] = $_GET['customer_name'];
                                            $selected = 'selected';

                                            /** Selecteert de juiste environment bij de selectie van de customer*/
                                            $environment_list = get_environmentlist();
                                            foreach ($environment_list as $environment) {
                                                if ($environment->get_customer_id() == get_customer_by_customer_name($customer_name)->get_customer_id()) {
                                                    $selected_environment = $environment;
                                                    break;
                                                }
                                            }

                                        }
                                    } else if (isset($_SESSION['customer_name'])) {
                                        if ($_SESSION['customer_name'] == $customer_name) {
                                            $selected = 'selected';

                                            /** Selecteert de juiste environment bij de selectie van de customer.*/
                                            $environment_list = get_environmentlist();
                                            foreach ($environment_list as $environment) {
                                                if ($environment->get_customer_id() == get_customer_by_customer_name($customer_name)->get_customer_id()) {
                                                    $selected_environment = $environment;
                                                    break;
                                                }
                                            }
                                        }
                                    } else {
                                        /** Selecteert de juiste environment bij de selectie van de customer.*/
                                        $environment_list = get_environmentlist();
                                        foreach ($environment_list as $environment) {
                                            if ($environment->get_customer_id() == get_customer_by_customer_name('Yvette')->get_customer_id()) {
                                                $selected_environment = $environment;
                                                break;
                                            }
                                        }

                                    }

                                    ?>

                                    <option value="<?= $customer_name ?>" <?= $selected ?>><?= $customer->get_customer_name() ?></option>

                                <?php }

                            } ?>
                        </select>
                    </form>
                </div>
                <div class="so-dropdown-element">
                    <form method="get" class="so-form">
                        <label class="so-label" for="sys-overview">Omgeving</label>
                        <select id="sys-overview" name="environment_name" onchange="this.form.submit();">
                            <?php

                            /** Bepaal de geselecteerde customer */

                            if (isset($_GET['customer_name'])) {
                                $selected_customer = get_customer_by_customer_name($_GET['customer_name']);
                            } else if (isset($_SESSION['customer_name'])) {
                                $selected_customer = get_customer_by_customer_name($_SESSION['customer_name']);
                            } else {
                                $customer_list = get_customerlist();
                                foreach ($customer_list as $cust) {
                                    if (customer_has_environment($cust)) {
                                        $selected_customer = $cust;
                                        break;
                                    }
                                }

                            }

                            /** Bepaalt de geselecteerde omgeving en geeft de juiste opties weer in de browse balk */
                            foreach (get_environmentlist() as $environment) {

                                $environment_name = $environment->get_environment_name();
                                $selected = '';

                                if ($environment->get_customer_id() == $selected_customer->get_customer_id()) {

                                    if (isset($_GET['environment_name'])) {
                                        if ($_GET['environment_name'] == $environment_name) {
                                            $_SESSION['environment_name'] = $_GET['environment_name']; // dit kan anders
                                            $selected_environment = get_environment_by_environment_name($_GET['environment_name']);
                                            $selected = 'selected';
                                        }
                                    } else if (isset($_SESSION['environment_name'])) {                  // dit kan anders
                                        if ($_SESSION['environment_name'] == $environment_name) {
                                            $selected_environment = get_environment_by_environment_name($_SESSION['environment_name']);
                                            $selected = 'selected';
                                        }
                                    } else {
                                        // De eerste omgeving van de selected customer pakken
                                        $selected_environment_array = [];
                                        foreach (get_environmentlist() as $env) {
                                            if ($env->get_customer_id() == $selected_customer->get_customer_id()) {
                                                array_push($selected_environment_array, $env);
                                            }
                                        }
                                        $selected_environment = $selected_environment_array[0];
                                    }


                                    ?>

                                    <option value="<?= $environment_name ?>" <?= $selected ?>> <?= $environment_name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="system-overview-servers-container">
            <div id="reload-content">


                <div class="progress-bar">
                    <span class="progress-bar-fill" style="width: 0%"></span>
                </div>
                <div class="desc">
                    <span>Ververst elke 10 seconden</span>
                </div>

                <?php foreach (get_sorted_virtualmachine_list_with_relations($selected_environment->get_environment_id()) as $vm) : ?>

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
                        <?php
                        $check_ingoing_relation = $vm->getIncomingRelationList();
                        $check_outgoing_relation = $vm->getOutgoingRelationList();
                        if (!empty($check_ingoing_relation) || !empty($check_outgoing_relation)) {
                            ?>
                            <div id="info-icon">
                                <a onClick="show_modal('<?= $vm->getName(); ?>')" class="close-modal">
                                    <i class="material-icons table-icons">info_outline</i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <?php foreach (get_sorted_virtualmachine_list_with_relations($selected_environment->get_environment_id()) as $vm) : ?>
        <div class="modal" id="modal-<?php echo $vm->getName(); ?>">
            <div id="modal-content">

                <div id="modal-title">
                    <p>Servernaam:</p>
                    <h1><?php echo $vm->getName(); ?></h1></div>
                <div id="IN-left">
                    <i class="material-icons table-icons arrow">arrow_upward</i>
                    <?php foreach ($vm->getOutgoingRelationList() as $relation): ?>
                        <div class="tooltip item">
                            <div><?php echo $relation->get_vm_name_from(); ?></div>
                            <span class="tooltiptext"><?php echo $relation->get_description(); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="OUT-right">
                    <i class="material-icons table-icons arrow">arrow_downward</i>
                    <?php foreach ($vm->getIncomingRelationList() as $relation): ?>
                        <div class="tooltip item">
                            <div><?php echo $relation->get_vm_name_to(); ?></div>
                            <span class="tooltiptext"><?php echo $relation->get_description(); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="close-modal">
                    <a onClick="hide_modal('<?= $vm->getName(); ?>')" class="close-modal"">
                    <i class="material-icons table-icons">close</i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>


<?php } else { ?>


    <div id="no_environments">
        <h2>Er zijn nog geen omgevingen.</h2>
    </div>

<?php } ?>

    <script>

        /** Reload scripts */
        function reload_pbar() {
            $(".progress-bar-fill").css({
                "width": "100%",
                "transition": "10s linear"
            });
        }

        function reload_servers() {
            $("#reload-content").load("./systemoverview.php #reload-content", reload_pbar);
        }

        reload_pbar();
        setInterval(reload_servers, 10000);

        /** Modal script **/
        function show_modal(server_name) {
            document.getElementById("modal-" + server_name).style.visibility = "visible";

        }

        function hide_modal(server_name) {
            document.getElementById("modal-" + server_name).style.visibility = "hidden";
        }

    </script>

    <!--Auto-refresh van het virtual machine overzicht -->

    <!--<script type="text/javascript" src="private/js/systemoverview.js"></script>-->

<?php include(SHARED_PATH . '/footer.php') ?>
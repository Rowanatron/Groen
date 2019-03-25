<?php

function get_sorted_virtualmachine_list() {
    include_once(PRIVATE_PATH . '/VirtualMachine.php');
    include_once (PRIVATE_PATH . '/ApiConnector.php');

    $api_connection = new ApiConnector;

    $virtual_machine_list = array();

    foreach ($api_connection->get_data() as $row) {
        $virtual_machine = new VirtualMachine(
            $row->HostSystem,
            $row->customer,
            $row->disk_size,
            $row->env,
            $row->latency,
            $row->memory,
            $row->name,
            $row->omgeving,
            $row->vCPU
        );
        $virtual_machine_list[$row->name] = $virtual_machine;
    }

    ksort($virtual_machine_list);

    return $virtual_machine_list;
}
<?php

function get_sorted_virtualmachine_list()
{
    include_once(CLASS_PATH . '/VirtualMachine.php');
    include_once(CLASS_PATH . '/ApiConnector.php');
    require_once(CLASS_PATH . '/DatabasePDO.php');


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


function vm_relation_add($environment_id, $vm_name_from, $vm_name_to, $relation_description, $bidirectional)
{
    $pdo = new DatabasePDO();
    $conn = $pdo->get();

    var_dump($relation_description);

    $data = [
        'environment_id' => $environment_id,
        'vm_name_from' => $vm_name_from,
        'vm_name_to' => $vm_name_to,
        'relation_description' => $relation_description,
    ];


    $query = "INSERT INTO `server_monitor`.`env_vm_relation` (`environment_id`, `vm_name_from`, `vm_name_to`, `description`) VALUES (:environment_id, :vm_name_from, :vm_name_to, :relation_description);
";


    try {
        $statement = $conn->prepare($query);
        $statement->execute($data);
    } catch (PDOException $e) {
        echo "Oops er ging iets mis {$e->getMessage()}";
    }

    if ($bidirectional == 1) {

        vm_relation_add($environment_id, $vm_name_to, $vm_name_from, $relation_description, 0);

    }


}
function get_sorted_virtualmachine_list_with_relations()
{
    include_once(CLASS_PATH . '/VirtualMachine.php');
    include_once(CLASS_PATH . '/ApiConnector.php');
    require_once(CLASS_PATH . '/DatabasePDO.php');


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

        $relation_list = get_relation_list($virtual_machine->getName());

        $virtual_machine->setRelationList($relation_list);

        $virtual_machine_list[$row->name] = $virtual_machine;
    }

    ksort($virtual_machine_list);

    return $virtual_machine_list;
}

function get_relation_list($vm_name){

    include_once(CLASS_PATH . '/Relation.php');
    require_once(CLASS_PATH . '/DatabasePDO.php');

    $pdo = new DatabasePDO();
    $conn = $pdo->get();
    $query = "SELECT * FROM env_vm_relation WHERE vm_name_from = :vm_name OR vm_name_to = :vm_name";


    try {
        $statement = $conn->prepare($query);
        $statement->execute(array('vm_name' => $vm_name));
    } catch (PDOException $e) {
        echo "Connection failed: {$e->getMessage()}";
    }

    $relation_list = array();

    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $relation = new Relation($row['relation_id'], $row['environment_id'], $row['vm_name_from'], $row['vm_name_to'], $row['description']);
        array_push($relation_list, $relation);
    }

    return $relation_list;

}
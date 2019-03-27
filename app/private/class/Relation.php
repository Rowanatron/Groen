<?php
class Relation
{
    private $relation_id;
    private $environment_id;
    private $vm_name_from;
    private $vm_name_to;
    private $description;

    public function __construct($relation_id, $environment_id, $vm_name_from, $vm_name_to, $description)
    {
        $this->relation_id = $relation_id;
        $this->environment_id = $environment_id;
        $this->vm_name_from = $vm_name_from;
        $this->vm_name_to = $vm_name_to;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getRelationId()
    {
        return $this->relation_id;
    }

    /**
     * @return mixed
     */
    public function getEnvironmentId()
    {
        return $this->environment_id;
    }

    /**
     * @return mixed
     */
    public function get_vm_name_from()
    {
        return $this->vm_name_from;
    }

    /**
     * @return mixed
     */
    public function get_vm_name_to()
    {
        return $this->vm_name_to;
    }

    /**
     * @return mixed
     */
    public function get_description()
    {
        return $this->description;
    }


}
    ?>
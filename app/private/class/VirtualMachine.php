<?php

class VirtualMachine
{

    private $hostSystem;
    private $customer;
    private $diskSize;
    private $environment;
    private $latency;
    private $memory;
    private $name;
    private $omgeving;
    private $vCPU;

    private $incoming_relation_list;
    private $outgoing_relation_list;

    public function __construct($hostSystem, $customer, $diskSize, $environment, $latency, $memory, $name, $omgeving, $vCPU)
    {
        $this->hostSystem = $hostSystem;
        $this->customer = $customer;
        $this->diskSize = $diskSize;
        $this->environment = $environment;
        $this->latency = $latency;
        $this->memory = $memory;
        $this->name = $name;
        $this->omgeving = $omgeving;
        $this->vCPU = $vCPU;
    }


    public function getHostSystem()
    {
        return $this->hostSystem;
    }

    public function setHostSystem($hostSystem)
    {
        $this->hostSystem = $hostSystem;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    public function getDiskSize()
    {
        return $this->diskSize;
    }

    public function setDiskSize($diskSize)
    {
        $this->diskSize = $diskSize;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    public function getLatency()
    {
        return $this->latency;
    }

    public function setLatency($latency)
    {
        $this->latency = $latency;
    }

    public function getMemory()
    {
        return $this->memory;
    }

    public function setMemory($memory)
    {
        $this->memory = $memory;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getOmgeving()
    {
        return $this->omgeving;
    }

    public function setOmgeving($omgeving)
    {
        $this->omgeving = $omgeving;
    }

    public function getVCPU()
    {
        return $this->vCPU;
    }

    public function setVCPU($vCPU)
    {
        $this->vCPU = $vCPU;
    }

    public function getIncomingRelationList()
    {
        return $this->incoming_relation_list;
    }

    public function setIncomingRelationList($incoming_relation_list)
    {
        $this->incoming_relation_list = $incoming_relation_list;
    }

    public function getOutgoingRelationList()
    {
        return $this->outgoing_relation_list;
    }

    public function setOutgoingRelationList($outgoing_relation_list)
    {
        $this->outgoing_relation_list = $outgoing_relation_list;
    }

}
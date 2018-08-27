<?php

class Migrations
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property migration
     */
    public $migration = null;

    /**
     * Property batch
     */
    public $batch = null;

    public function __construct()
    {
        $this->exchangeArray([]);
    }

    /**
     * Method exchange array
     *
     * Pass data from hydrator to object
     */
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id']:null; //   int
        $this->migration = (!empty($data['migration'])) ? $data['migration']:null; //   varchar
        $this->batch = (!empty($data['batch'])) ? $data['batch']:null; //   int
    }

    /**
     * Method get array copy
     *
     * Get a copy of this object
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}


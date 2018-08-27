<?php

class RamosCursos
{

    /**
     * Property ramo_id
     */
    public $ramo_id = null;

    /**
     * Property curso_id
     */
    public $curso_id = null;

    /**
     * Property created_at
     */
    public $created_at = null;

    /**
     * Property updated_at
     */
    public $updated_at = null;

    /**
     * Property deleted_at
     */
    public $deleted_at = null;

    /**
     * Property id
     */
    public $id = null;

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
        $this->ramo_id = (!empty($data['ramo_id'])) ? $data['ramo_id']:null; //   int
        $this->curso_id = (!empty($data['curso_id'])) ? $data['curso_id']:null; //   int
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
        $this->deleted_at = (!empty($data['deleted_at'])) ? $data['deleted_at']:null; //   timestamp
        $this->id = (!empty($data['id'])) ? $data['id']:null; //   int
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


<?php

class ActividadesRamosCursos
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property ramo_curso_id
     */
    public $ramo_curso_id = null;

    /**
     * Property actividad_id
     */
    public $actividad_id = null;

    /**
     * Property deleted_at
     */
    public $deleted_at = null;

    /**
     * Property created_at
     */
    public $created_at = null;

    /**
     * Property updated_at
     */
    public $updated_at = null;

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
        $this->ramo_curso_id = (!empty($data['ramo_curso_id'])) ? $data['ramo_curso_id']:null; //   int
        $this->actividad_id = (!empty($data['actividad_id'])) ? $data['actividad_id']:null; //   int
        $this->deleted_at = (!empty($data['deleted_at'])) ? $data['deleted_at']:null; //   timestamp
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
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


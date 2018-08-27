<?php

class ActividadesHabilidades
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property nombre
     */
    public $nombre = null;

    /**
     * Property descripcion
     */
    public $descripcion = null;

    /**
     * Property actividad_id
     */
    public $actividad_id = null;

    /**
     * Property created_at
     */
    public $created_at = null;

    /**
     * Property updated_at
     */
    public $updated_at = null;

    /**
     * Property habilidad_id
     */
    public $habilidad_id = null;

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
        $this->nombre = (!empty($data['nombre'])) ? $data['nombre']:null; //   varchar
        $this->descripcion = (!empty($data['descripcion'])) ? $data['descripcion']:null; //   varchar
        $this->actividad_id = (!empty($data['actividad_id'])) ? $data['actividad_id']:null; //   int
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
        $this->habilidad_id = (!empty($data['habilidad_id'])) ? $data['habilidad_id']:null; //   int
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


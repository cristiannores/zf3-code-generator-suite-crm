<?php

class Eventos
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
     * Property fecha_evento
     */
    public $fecha_evento = null;

    /**
     * Property created_at
     */
    public $created_at = null;

    /**
     * Property updated_at
     */
    public $updated_at = null;

    /**
     * Property user_id
     */
    public $user_id = null;

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
        $this->fecha_evento = (!empty($data['fecha_evento'])) ? $data['fecha_evento']:null; //   timestamp
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id']:null; //   int
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


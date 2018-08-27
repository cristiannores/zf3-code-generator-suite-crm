<?php

class UsersMensajes
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property de
     */
    public $de = null;

    /**
     * Property para
     */
    public $para = null;

    /**
     * Property mensaje
     */
    public $mensaje = null;

    /**
     * Property leido
     */
    public $leido = null;

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
     * Property hash
     */
    public $hash = null;

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
        $this->de = (!empty($data['de'])) ? $data['de']:null; //   int
        $this->para = (!empty($data['para'])) ? $data['para']:null; //   int
        $this->mensaje = (!empty($data['mensaje'])) ? $data['mensaje']:null; //   text
        $this->leido = (!empty($data['leido'])) ? $data['leido']:null; //   tinyint
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
        $this->deleted_at = (!empty($data['deleted_at'])) ? $data['deleted_at']:null; //   timestamp
        $this->hash = (!empty($data['hash'])) ? $data['hash']:null; //   varchar
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


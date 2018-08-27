<?php

class NotificacionesUsuario
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property user_id
     */
    public $user_id = null;

    /**
     * Property mensaje
     */
    public $mensaje = null;

    /**
     * Property link
     */
    public $link = null;

    /**
     * Property tipo
     */
    public $tipo = null;

    /**
     * Property leido
     */
    public $leido = '0';

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
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id']:null; //   int
        $this->mensaje = (!empty($data['mensaje'])) ? $data['mensaje']:null; //   text
        $this->link = (!empty($data['link'])) ? $data['link']:null; //   varchar
        $this->tipo = (!empty($data['tipo'])) ? $data['tipo']:null; //   varchar
        $this->leido = (!empty($data['leido'])) ? $data['leido']:null; //  0 tinyint
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


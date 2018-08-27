<?php

class Actividades
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
     * Property objetivos
     */
    public $objetivos = null;

    /**
     * Property avatar
     */
    public $avatar = null;

    /**
     * Property duracion
     */
    public $duracion = null;

    /**
     * Property descripcion
     */
    public $descripcion = null;

    /**
     * Property user_id
     */
    public $user_id = null;

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

    /**
     * Property avatar_public
     */
    public $avatar_public = null;

    /**
     * Property puntaje
     */
    public $puntaje = null;

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
        $this->objetivos = (!empty($data['objetivos'])) ? $data['objetivos']:null; //   text
        $this->avatar = (!empty($data['avatar'])) ? $data['avatar']:null; //   varchar
        $this->duracion = (!empty($data['duracion'])) ? $data['duracion']:null; //   varchar
        $this->descripcion = (!empty($data['descripcion'])) ? $data['descripcion']:null; //   text
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id']:null; //   int
        $this->deleted_at = (!empty($data['deleted_at'])) ? $data['deleted_at']:null; //   timestamp
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
        $this->avatar_public = (!empty($data['avatar_public'])) ? $data['avatar_public']:null; //   varchar
        $this->puntaje = (!empty($data['puntaje'])) ? $data['puntaje']:null; //   int
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


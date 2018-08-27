<?php

class UsersHabilidades
{

    /**
     * Property user_id
     */
    public $user_id = null;

    /**
     * Property habilidad_id
     */
    public $habilidad_id = null;

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
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id']:null; //   int
        $this->habilidad_id = (!empty($data['habilidad_id'])) ? $data['habilidad_id']:null; //   int
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


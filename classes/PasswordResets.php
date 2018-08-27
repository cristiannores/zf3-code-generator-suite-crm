<?php

class PasswordResets
{

    /**
     * Property email
     */
    public $email = null;

    /**
     * Property token
     */
    public $token = null;

    /**
     * Property created_at
     */
    public $created_at = null;

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
        $this->email = (!empty($data['email'])) ? $data['email']:null; //   varchar
        $this->token = (!empty($data['token'])) ? $data['token']:null; //   varchar
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
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


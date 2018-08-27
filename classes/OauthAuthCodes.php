<?php

class OauthAuthCodes
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
     * Property client_id
     */
    public $client_id = null;

    /**
     * Property scopes
     */
    public $scopes = null;

    /**
     * Property revoked
     */
    public $revoked = null;

    /**
     * Property expires_at
     */
    public $expires_at = null;

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
        $this->id = (!empty($data['id'])) ? $data['id']:null; //   varchar
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id']:null; //   int
        $this->client_id = (!empty($data['client_id'])) ? $data['client_id']:null; //   int
        $this->scopes = (!empty($data['scopes'])) ? $data['scopes']:null; //   text
        $this->revoked = (!empty($data['revoked'])) ? $data['revoked']:null; //   tinyint
        $this->expires_at = (!empty($data['expires_at'])) ? $data['expires_at']:null; //   datetime
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


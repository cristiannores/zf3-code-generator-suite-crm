<?php

class OauthAccessTokens
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
     * Property name
     */
    public $name = null;

    /**
     * Property scopes
     */
    public $scopes = null;

    /**
     * Property revoked
     */
    public $revoked = null;

    /**
     * Property created_at
     */
    public $created_at = null;

    /**
     * Property updated_at
     */
    public $updated_at = null;

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
        $this->name = (!empty($data['name'])) ? $data['name']:null; //   varchar
        $this->scopes = (!empty($data['scopes'])) ? $data['scopes']:null; //   text
        $this->revoked = (!empty($data['revoked'])) ? $data['revoked']:null; //   tinyint
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
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


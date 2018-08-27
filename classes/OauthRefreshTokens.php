<?php

class OauthRefreshTokens
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property access_token_id
     */
    public $access_token_id = null;

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
        $this->access_token_id = (!empty($data['access_token_id'])) ? $data['access_token_id']:null; //   varchar
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


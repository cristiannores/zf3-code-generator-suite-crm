<?php

class Notifications
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property type
     */
    public $type = null;

    /**
     * Property notifiable_type
     */
    public $notifiable_type = null;

    /**
     * Property notifiable_id
     */
    public $notifiable_id = null;

    /**
     * Property data
     */
    public $data = null;

    /**
     * Property read_at
     */
    public $read_at = null;

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
        $this->id = (!empty($data['id'])) ? $data['id']:null; //   char
        $this->type = (!empty($data['type'])) ? $data['type']:null; //   varchar
        $this->notifiable_type = (!empty($data['notifiable_type'])) ? $data['notifiable_type']:null; //   varchar
        $this->notifiable_id = (!empty($data['notifiable_id'])) ? $data['notifiable_id']:null; //   bigint
        $this->data = (!empty($data['data'])) ? $data['data']:null; //   text
        $this->read_at = (!empty($data['read_at'])) ? $data['read_at']:null; //   timestamp
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

    /**
     * Method to validate data object
     */
    public function isValid($data = null)
    {
        if ( $data ) {
        	$data = $this->exchangeArray($data);
        }

        if ($this->id) {
        	$validator = new Zend\Validator\ValidatorChain();
        	$validator->attach(new Zend\Validator\Digits());
        	if (!$validator->isValid($this->id)) { 
        		return false;
        	}
        }
        return true;
    }


}


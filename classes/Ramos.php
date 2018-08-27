<?php

class Ramos
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
     * Property imagen
     */
    public $imagen = '';

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
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
        $this->deleted_at = (!empty($data['deleted_at'])) ? $data['deleted_at']:null; //   timestamp
        $this->imagen = (!empty($data['imagen'])) ? $data['imagen']:null; //   varchar
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


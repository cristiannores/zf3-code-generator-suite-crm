<?php

class Comentarios
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property comentario
     */
    public $comentario = null;

    /**
     * Property puntaje
     */
    public $puntaje = null;

    /**
     * Property status
     */
    public $status = null;

    /**
     * Property user_id
     */
    public $user_id = null;

    /**
     * Property actividad_id
     */
    public $actividad_id = null;

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
        $this->comentario = (!empty($data['comentario'])) ? $data['comentario']:null; //   text
        $this->puntaje = (!empty($data['puntaje'])) ? $data['puntaje']:null; //   double
        $this->status = (!empty($data['status'])) ? $data['status']:null; //   tinyint
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id']:null; //   int
        $this->actividad_id = (!empty($data['actividad_id'])) ? $data['actividad_id']:null; //   int
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


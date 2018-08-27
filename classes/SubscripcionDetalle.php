<?php

class SubscripcionDetalle
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property subscripcion_id
     */
    public $subscripcion_id = null;

    /**
     * Property item
     */
    public $item = null;

    /**
     * Property valor
     */
    public $valor = null;

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
        $this->subscripcion_id = (!empty($data['subscripcion_id'])) ? $data['subscripcion_id']:null; //   int
        $this->item = (!empty($data['item'])) ? $data['item']:null; //   varchar
        $this->valor = (!empty($data['valor'])) ? $data['valor']:null; //   varchar
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
        $this->deleted_at = (!empty($data['deleted_at'])) ? $data['deleted_at']:null; //   timestamp
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


<?php

class LeadsCstm
{

    /**
     * Property id_c
     */
    public $id_c = null;

    /**
     * Property jjwg_maps_lng_c
     */
    public $jjwg_maps_lng_c = '0.00000000';

    /**
     * Property jjwg_maps_lat_c
     */
    public $jjwg_maps_lat_c = '0.00000000';

    /**
     * Property jjwg_maps_geocode_status_c
     */
    public $jjwg_maps_geocode_status_c = null;

    /**
     * Property jjwg_maps_address_c
     */
    public $jjwg_maps_address_c = null;

    /**
     * Property politicas_privacidad_c
     */
    public $politicas_privacidad_c = '0';

    /**
     * Property recibir_notificaciones_c
     */
    public $recibir_notificaciones_c = '0';

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
        $this->id_c = (!empty($data['id_c'])) ? $data['id_c']:null; //   char
        $this->jjwg_maps_lng_c = (!empty($data['jjwg_maps_lng_c'])) ? $data['jjwg_maps_lng_c']:null; //  0.00000000 float
        $this->jjwg_maps_lat_c = (!empty($data['jjwg_maps_lat_c'])) ? $data['jjwg_maps_lat_c']:null; //  0.00000000 float
        $this->jjwg_maps_geocode_status_c = (!empty($data['jjwg_maps_geocode_status_c'])) ? $data['jjwg_maps_geocode_status_c']:null; //   varchar
        $this->jjwg_maps_address_c = (!empty($data['jjwg_maps_address_c'])) ? $data['jjwg_maps_address_c']:null; //   varchar
        $this->politicas_privacidad_c = (!empty($data['politicas_privacidad_c'])) ? $data['politicas_privacidad_c']:null; //  0 tinyint
        $this->recibir_notificaciones_c = (!empty($data['recibir_notificaciones_c'])) ? $data['recibir_notificaciones_c']:null; //  0 tinyint
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


<?php

class ContactsCstm
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
     * Property aos_invoices_id_c
     */
    public $aos_invoices_id_c = null;

    /**
     * Property campaign_cross_destiny_c
     */
    public $campaign_cross_destiny_c = null;

    /**
     * Property campaign_cross_user_name_c
     */
    public $campaign_cross_user_name_c = null;

    /**
     * Property campaign_fugados_user_name_c
     */
    public $campaign_fugados_user_name_c = null;

    /**
     * Property campaign_cross_description_c
     */
    public $campaign_cross_description_c = null;

    /**
     * Property campaign_fugados_description_c
     */
    public $campaign_fugados_description_c = null;

    /**
     * Property emergency_name_c
     */
    public $emergency_name_c = null;

    /**
     * Property emergency_phone_c
     */
    public $emergency_phone_c = null;

    /**
     * Property emergency_relationship_c
     */
    public $emergency_relationship_c = null;

    /**
     * Property company_rut_c
     */
    public $company_rut_c = null;

    /**
     * Property vip_c
     */
    public $vip_c = '0';

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
        $this->aos_invoices_id_c = (!empty($data['aos_invoices_id_c'])) ? $data['aos_invoices_id_c']:null; //   char
        $this->campaign_cross_destiny_c = (!empty($data['campaign_cross_destiny_c'])) ? $data['campaign_cross_destiny_c']:null; //   varchar
        $this->campaign_cross_user_name_c = (!empty($data['campaign_cross_user_name_c'])) ? $data['campaign_cross_user_name_c']:null; //   varchar
        $this->campaign_fugados_user_name_c = (!empty($data['campaign_fugados_user_name_c'])) ? $data['campaign_fugados_user_name_c']:null; //   varchar
        $this->campaign_cross_description_c = (!empty($data['campaign_cross_description_c'])) ? $data['campaign_cross_description_c']:null; //   varchar
        $this->campaign_fugados_description_c = (!empty($data['campaign_fugados_description_c'])) ? $data['campaign_fugados_description_c']:null; //   varchar
        $this->emergency_name_c = (!empty($data['emergency_name_c'])) ? $data['emergency_name_c']:null; //   varchar
        $this->emergency_phone_c = (!empty($data['emergency_phone_c'])) ? $data['emergency_phone_c']:null; //   varchar
        $this->emergency_relationship_c = (!empty($data['emergency_relationship_c'])) ? $data['emergency_relationship_c']:null; //   varchar
        $this->company_rut_c = (!empty($data['company_rut_c'])) ? $data['company_rut_c']:null; //   varchar
        $this->vip_c = (!empty($data['vip_c'])) ? $data['vip_c']:null; //  0 tinyint
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


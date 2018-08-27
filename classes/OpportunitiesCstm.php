<?php

class OpportunitiesCstm
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
     * Property pasajeros_adultos_c
     */
    public $pasajeros_adultos_c = null;

    /**
     * Property pasajeros_ninos_c
     */
    public $pasajeros_ninos_c = null;

    /**
     * Property edad_nino_c
     */
    public $edad_nino_c = null;

    /**
     * Property canal_c
     */
    public $canal_c = null;

    /**
     * Property destino_c
     */
    public $destino_c = null;

    /**
     * Property analytics_c
     */
    public $analytics_c = null;

    /**
     * Property fecha_viaje_c
     */
    public $fecha_viaje_c = null;

    /**
     * Property fecha_flexible_c
     */
    public $fecha_flexible_c = '0';

    /**
     * Property fecha_asignacion_c
     */
    public $fecha_asignacion_c = null;

    /**
     * Property producto_id_c
     */
    public $producto_id_c = null;

    /**
     * Property producto_pdf_c
     */
    public $producto_pdf_c = null;

    /**
     * Property producto_url_c
     */
    public $producto_url_c = null;

    /**
     * Property touroperador_c
     */
    public $touroperador_c = null;

    /**
     * Property producto_nombre_c
     */
    public $producto_nombre_c = null;

    /**
     * Property agente_c
     */
    public $agente_c = null;

    /**
     * Property cierre_motivo_c
     */
    public $cierre_motivo_c = null;

    /**
     * Property cierre_comentario_c
     */
    public $cierre_comentario_c = null;

    /**
     * Property cierre_tipo_c
     */
    public $cierre_tipo_c = null;

    /**
     * Property aos_invoices_id_c
     */
    public $aos_invoices_id_c = null;

    /**
     * Property canal2_c
     */
    public $canal2_c = null;

    /**
     * Property opportunity_id_c
     */
    public $opportunity_id_c = null;

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
        $this->pasajeros_adultos_c = (!empty($data['pasajeros_adultos_c'])) ? $data['pasajeros_adultos_c']:null; //   int
        $this->pasajeros_ninos_c = (!empty($data['pasajeros_ninos_c'])) ? $data['pasajeros_ninos_c']:null; //   int
        $this->edad_nino_c = (!empty($data['edad_nino_c'])) ? $data['edad_nino_c']:null; //   varchar
        $this->canal_c = (!empty($data['canal_c'])) ? $data['canal_c']:null; //   varchar
        $this->destino_c = (!empty($data['destino_c'])) ? $data['destino_c']:null; //   varchar
        $this->analytics_c = (!empty($data['analytics_c'])) ? $data['analytics_c']:null; //   varchar
        $this->fecha_viaje_c = (!empty($data['fecha_viaje_c'])) ? $data['fecha_viaje_c']:null; //   date
        $this->fecha_flexible_c = (!empty($data['fecha_flexible_c'])) ? $data['fecha_flexible_c']:null; //  0 tinyint
        $this->fecha_asignacion_c = (!empty($data['fecha_asignacion_c'])) ? $data['fecha_asignacion_c']:null; //   date
        $this->producto_id_c = (!empty($data['producto_id_c'])) ? $data['producto_id_c']:null; //   varchar
        $this->producto_pdf_c = (!empty($data['producto_pdf_c'])) ? $data['producto_pdf_c']:null; //   varchar
        $this->producto_url_c = (!empty($data['producto_url_c'])) ? $data['producto_url_c']:null; //   varchar
        $this->touroperador_c = (!empty($data['touroperador_c'])) ? $data['touroperador_c']:null; //   varchar
        $this->producto_nombre_c = (!empty($data['producto_nombre_c'])) ? $data['producto_nombre_c']:null; //   varchar
        $this->agente_c = (!empty($data['agente_c'])) ? $data['agente_c']:null; //   varchar
        $this->cierre_motivo_c = (!empty($data['cierre_motivo_c'])) ? $data['cierre_motivo_c']:null; //   varchar
        $this->cierre_comentario_c = (!empty($data['cierre_comentario_c'])) ? $data['cierre_comentario_c']:null; //   text
        $this->cierre_tipo_c = (!empty($data['cierre_tipo_c'])) ? $data['cierre_tipo_c']:null; //   varchar
        $this->aos_invoices_id_c = (!empty($data['aos_invoices_id_c'])) ? $data['aos_invoices_id_c']:null; //   char
        $this->canal2_c = (!empty($data['canal2_c'])) ? $data['canal2_c']:null; //   varchar
        $this->opportunity_id_c = (!empty($data['opportunity_id_c'])) ? $data['opportunity_id_c']:null; //   varchar
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


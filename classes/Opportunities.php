<?php

class Opportunities
{

    /**
     * Property id
     */
    public $id = null;

    /**
     * Property name
     */
    public $name = null;

    /**
     * Property date_entered
     */
    public $date_entered = null;

    /**
     * Property date_modified
     */
    public $date_modified = null;

    /**
     * Property modified_user_id
     */
    public $modified_user_id = null;

    /**
     * Property created_by
     */
    public $created_by = null;

    /**
     * Property description
     */
    public $description = null;

    /**
     * Property deleted
     */
    public $deleted = '0';

    /**
     * Property assigned_user_id
     */
    public $assigned_user_id = null;

    /**
     * Property opportunity_type
     */
    public $opportunity_type = null;

    /**
     * Property campaign_id
     */
    public $campaign_id = null;

    /**
     * Property lead_source
     */
    public $lead_source = null;

    /**
     * Property amount
     */
    public $amount = null;

    /**
     * Property amount_usdollar
     */
    public $amount_usdollar = null;

    /**
     * Property sw_comentario_cliente
     */
    public $sw_comentario_cliente = null;

    /**
     * Property currency_id
     */
    public $currency_id = null;

    /**
     * Property date_closed
     */
    public $date_closed = null;

    /**
     * Property next_step
     */
    public $next_step = null;

    /**
     * Property sales_stage
     */
    public $sales_stage = null;

    /**
     * Property probability
     */
    public $probability = null;

    /**
     * Property sw_comentario_ejecutiva
     */
    public $sw_comentario_ejecutiva = null;

    /**
     * Property cross_hotel
     */
    public $cross_hotel = null;

    /**
     * Property cross_asistencia
     */
    public $cross_asistencia = null;

    /**
     * Property sw_priority
     */
    public $sw_priority = null;

    /**
     * Property sw_date_assigned
     */
    public $sw_date_assigned = null;

    /**
     * Property swrm_solicitud_id
     */
    public $swrm_solicitud_id = null;

    /**
     * Property sw_estado_wf
     */
    public $sw_estado_wf = null;

    /**
     * Property swomentario_ejecutiva
     */
    public $swomentario_ejecutiva = null;

    /**
     * Property op_productos
     */
    public $op_productos = null;

    /**
     * Property op_numero_negocio
     */
    public $op_numero_negocio = null;

    /**
     * Property sw_tipo_hotel
     */
    public $sw_tipo_hotel = null;

    /**
     * Property sw_destino
     */
    public $sw_destino = null;

    /**
     * Property sw_agente
     */
    public $sw_agente = null;

    /**
     * Property swomentarioliente
     */
    public $swomentarioliente = null;

    /**
     * Property sw_resumen_json
     */
    public $sw_resumen_json = null;

    /**
     * Property sw_id_agente
     */
    public $sw_id_agente = null;

    /**
     * Property sw_email
     */
    public $sw_email = null;

    /**
     * Property sw_rut
     */
    public $sw_rut = null;

    /**
     * Property sw_log_asignacion
     */
    public $sw_log_asignacion = null;

    /**
     * Property sw_tipoierre
     */
    public $sw_tipoierre = null;

    /**
     * Property cross_asistencia1
     */
    public $cross_asistencia1 = null;

    /**
     * Property sw_fecha_viaje
     */
    public $sw_fecha_viaje = null;

    /**
     * Property cierre_tipo
     */
    public $cierre_tipo = null;

    /**
     * Property edad_nino
     */
    public $edad_nino = null;

    /**
     * Property tour_operador
     */
    public $tour_operador = null;

    /**
     * Property produto_nombre
     */
    public $produto_nombre = null;

    /**
     * Property producto_pdf
     */
    public $producto_pdf = null;

    /**
     * Property analytics
     */
    public $analytics = null;

    /**
     * Property product_id
     */
    public $product_id = null;

    /**
     * Property pasajeros_adultos
     */
    public $pasajeros_adultos = null;

    /**
     * Property pasajeros_ninos
     */
    public $pasajeros_ninos = null;

    /**
     * Property producto_nombre
     */
    public $producto_nombre = null;

    /**
     * Property producto_id
     */
    public $producto_id = null;

    /**
     * Property producto_url
     */
    public $producto_url = null;

    /**
     * Property canal
     */
    public $canal = null;

    /**
     * Property fecha_flexible
     */
    public $fecha_flexible = null;

    /**
     * Property cantidad_habitaciones
     */
    public $cantidad_habitaciones = null;

    /**
     * Property referido_id
     */
    public $referido_id = null;

    /**
     * Property sw_asigado_por
     */
    public $sw_asigado_por = null;

    /**
     * Property sw_date_closed
     */
    public $sw_date_closed = null;

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
        $this->name = (!empty($data['name'])) ? $data['name']:null; //   varchar
        $this->date_entered = (!empty($data['date_entered'])) ? $data['date_entered']:null; //   datetime
        $this->date_modified = (!empty($data['date_modified'])) ? $data['date_modified']:null; //   datetime
        $this->modified_user_id = (!empty($data['modified_user_id'])) ? $data['modified_user_id']:null; //   char
        $this->created_by = (!empty($data['created_by'])) ? $data['created_by']:null; //   char
        $this->description = (!empty($data['description'])) ? $data['description']:null; //   text
        $this->deleted = (!empty($data['deleted'])) ? $data['deleted']:null; //  0 tinyint
        $this->assigned_user_id = (!empty($data['assigned_user_id'])) ? $data['assigned_user_id']:null; //   char
        $this->opportunity_type = (!empty($data['opportunity_type'])) ? $data['opportunity_type']:null; //   varchar
        $this->campaign_id = (!empty($data['campaign_id'])) ? $data['campaign_id']:null; //   char
        $this->lead_source = (!empty($data['lead_source'])) ? $data['lead_source']:null; //   varchar
        $this->amount = (!empty($data['amount'])) ? $data['amount']:null; //   double
        $this->amount_usdollar = (!empty($data['amount_usdollar'])) ? $data['amount_usdollar']:null; //   double
        $this->sw_comentario_cliente = (!empty($data['sw_comentario_cliente'])) ? $data['sw_comentario_cliente']:null; //   int
        $this->currency_id = (!empty($data['currency_id'])) ? $data['currency_id']:null; //   char
        $this->date_closed = (!empty($data['date_closed'])) ? $data['date_closed']:null; //   date
        $this->next_step = (!empty($data['next_step'])) ? $data['next_step']:null; //   varchar
        $this->sales_stage = (!empty($data['sales_stage'])) ? $data['sales_stage']:null; //   varchar
        $this->probability = (!empty($data['probability'])) ? $data['probability']:null; //   double
        $this->sw_comentario_ejecutiva = (!empty($data['sw_comentario_ejecutiva'])) ? $data['sw_comentario_ejecutiva']:null; //   varchar
        $this->cross_hotel = (!empty($data['cross_hotel'])) ? $data['cross_hotel']:null; //   int
        $this->cross_asistencia = (!empty($data['cross_asistencia'])) ? $data['cross_asistencia']:null; //   int
        $this->sw_priority = (!empty($data['sw_priority'])) ? $data['sw_priority']:null; //   varchar
        $this->sw_date_assigned = (!empty($data['sw_date_assigned'])) ? $data['sw_date_assigned']:null; //   datetime
        $this->swrm_solicitud_id = (!empty($data['swrm_solicitud_id'])) ? $data['swrm_solicitud_id']:null; //   varchar
        $this->sw_estado_wf = (!empty($data['sw_estado_wf'])) ? $data['sw_estado_wf']:null; //   varchar
        $this->swomentario_ejecutiva = (!empty($data['swomentario_ejecutiva'])) ? $data['swomentario_ejecutiva']:null; //   varchar
        $this->op_productos = (!empty($data['op_productos'])) ? $data['op_productos']:null; //   text
        $this->op_numero_negocio = (!empty($data['op_numero_negocio'])) ? $data['op_numero_negocio']:null; //   varchar
        $this->sw_tipo_hotel = (!empty($data['sw_tipo_hotel'])) ? $data['sw_tipo_hotel']:null; //   varchar
        $this->sw_destino = (!empty($data['sw_destino'])) ? $data['sw_destino']:null; //   varchar
        $this->sw_agente = (!empty($data['sw_agente'])) ? $data['sw_agente']:null; //   varchar
        $this->swomentarioliente = (!empty($data['swomentarioliente'])) ? $data['swomentarioliente']:null; //   int
        $this->sw_resumen_json = (!empty($data['sw_resumen_json'])) ? $data['sw_resumen_json']:null; //   text
        $this->sw_id_agente = (!empty($data['sw_id_agente'])) ? $data['sw_id_agente']:null; //   varchar
        $this->sw_email = (!empty($data['sw_email'])) ? $data['sw_email']:null; //   varchar
        $this->sw_rut = (!empty($data['sw_rut'])) ? $data['sw_rut']:null; //   varchar
        $this->sw_log_asignacion = (!empty($data['sw_log_asignacion'])) ? $data['sw_log_asignacion']:null; //   int
        $this->sw_tipoierre = (!empty($data['sw_tipoierre'])) ? $data['sw_tipoierre']:null; //   varchar
        $this->cross_asistencia1 = (!empty($data['cross_asistencia1'])) ? $data['cross_asistencia1']:null; //   int
        $this->sw_fecha_viaje = (!empty($data['sw_fecha_viaje'])) ? $data['sw_fecha_viaje']:null; //   date
        $this->cierre_tipo = (!empty($data['cierre_tipo'])) ? $data['cierre_tipo']:null; //   varchar
        $this->edad_nino = (!empty($data['edad_nino'])) ? $data['edad_nino']:null; //   varchar
        $this->tour_operador = (!empty($data['tour_operador'])) ? $data['tour_operador']:null; //   varchar
        $this->produto_nombre = (!empty($data['produto_nombre'])) ? $data['produto_nombre']:null; //   varchar
        $this->producto_pdf = (!empty($data['producto_pdf'])) ? $data['producto_pdf']:null; //   varchar
        $this->analytics = (!empty($data['analytics'])) ? $data['analytics']:null; //   varchar
        $this->product_id = (!empty($data['product_id'])) ? $data['product_id']:null; //   varchar
        $this->pasajeros_adultos = (!empty($data['pasajeros_adultos'])) ? $data['pasajeros_adultos']:null; //   varchar
        $this->pasajeros_ninos = (!empty($data['pasajeros_ninos'])) ? $data['pasajeros_ninos']:null; //   varchar
        $this->producto_nombre = (!empty($data['producto_nombre'])) ? $data['producto_nombre']:null; //   varchar
        $this->producto_id = (!empty($data['producto_id'])) ? $data['producto_id']:null; //   varchar
        $this->producto_url = (!empty($data['producto_url'])) ? $data['producto_url']:null; //   varchar
        $this->canal = (!empty($data['canal'])) ? $data['canal']:null; //   varchar
        $this->fecha_flexible = (!empty($data['fecha_flexible'])) ? $data['fecha_flexible']:null; //   varchar
        $this->cantidad_habitaciones = (!empty($data['cantidad_habitaciones'])) ? $data['cantidad_habitaciones']:null; //   varchar
        $this->referido_id = (!empty($data['referido_id'])) ? $data['referido_id']:null; //   varchar
        $this->sw_asigado_por = (!empty($data['sw_asigado_por'])) ? $data['sw_asigado_por']:null; //   varchar
        $this->sw_date_closed = (!empty($data['sw_date_closed'])) ? $data['sw_date_closed']:null; //   datetime
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


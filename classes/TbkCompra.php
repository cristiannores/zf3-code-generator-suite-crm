<?php

class TbkCompra
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
     * Property orden_compra
     */
    public $orden_compra = null;

    /**
     * Property valor
     */
    public $valor = null;

    /**
     * Property detalle
     */
    public $detalle = null;

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
     * Property accountingDate
     */
    public $accountingDate = null;

    /**
     * Property buyOrder
     */
    public $buyOrder = null;

    /**
     * Property cardNumber
     */
    public $cardNumber = null;

    /**
     * Property cardExpirationDate
     */
    public $cardExpirationDate = null;

    /**
     * Property authorizationCode
     */
    public $authorizationCode = null;

    /**
     * Property paymentTypeCode
     */
    public $paymentTypeCode = null;

    /**
     * Property responseCode
     */
    public $responseCode = null;

    /**
     * Property sharesNumber
     */
    public $sharesNumber = null;

    /**
     * Property amount
     */
    public $amount = null;

    /**
     * Property commerceCode
     */
    public $commerceCode = null;

    /**
     * Property sessionId
     */
    public $sessionId = null;

    /**
     * Property transactionDate
     */
    public $transactionDate = null;

    /**
     * Property VCI
     */
    public $VCI = null;

    /**
     * Property token_ws
     */
    public $token_ws = null;

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
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id']:null; //   int
        $this->orden_compra = (!empty($data['orden_compra'])) ? $data['orden_compra']:null; //   int
        $this->valor = (!empty($data['valor'])) ? $data['valor']:null; //   int
        $this->detalle = (!empty($data['detalle'])) ? $data['detalle']:null; //   varchar
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
        $this->deleted_at = (!empty($data['deleted_at'])) ? $data['deleted_at']:null; //   timestamp
        $this->accountingDate = (!empty($data['accountingDate'])) ? $data['accountingDate']:null; //   varchar
        $this->buyOrder = (!empty($data['buyOrder'])) ? $data['buyOrder']:null; //   varchar
        $this->cardNumber = (!empty($data['cardNumber'])) ? $data['cardNumber']:null; //   varchar
        $this->cardExpirationDate = (!empty($data['cardExpirationDate'])) ? $data['cardExpirationDate']:null; //   varchar
        $this->authorizationCode = (!empty($data['authorizationCode'])) ? $data['authorizationCode']:null; //   varchar
        $this->paymentTypeCode = (!empty($data['paymentTypeCode'])) ? $data['paymentTypeCode']:null; //   varchar
        $this->responseCode = (!empty($data['responseCode'])) ? $data['responseCode']:null; //   int
        $this->sharesNumber = (!empty($data['sharesNumber'])) ? $data['sharesNumber']:null; //   varchar
        $this->amount = (!empty($data['amount'])) ? $data['amount']:null; //   varchar
        $this->commerceCode = (!empty($data['commerceCode'])) ? $data['commerceCode']:null; //   varchar
        $this->sessionId = (!empty($data['sessionId'])) ? $data['sessionId']:null; //   varchar
        $this->transactionDate = (!empty($data['transactionDate'])) ? $data['transactionDate']:null; //   datetime
        $this->VCI = (!empty($data['VCI'])) ? $data['VCI']:null; //   varchar
        $this->token_ws = (!empty($data['token_ws'])) ? $data['token_ws']:null; //   varchar
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


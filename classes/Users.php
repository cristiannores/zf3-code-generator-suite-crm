<?php

class Users
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
     * Property email
     */
    public $email = null;

    /**
     * Property password
     */
    public $password = null;

    /**
     * Property deleted_at
     */
    public $deleted_at = null;

    /**
     * Property remember_token
     */
    public $remember_token = null;

    /**
     * Property created_at
     */
    public $created_at = null;

    /**
     * Property updated_at
     */
    public $updated_at = null;

    /**
     * Property descripcion
     */
    public $descripcion = null;

    /**
     * Property avatar
     */
    public $avatar = null;

    /**
     * Property completa_datos
     */
    public $completa_datos = null;

    /**
     * Property avatar_public
     */
    public $avatar_public = null;

    /**
     * Property apellido
     */
    public $apellido = null;

    /**
     * Property dirigido
     */
    public $dirigido = null;

    /**
     * Property genero
     */
    public $genero = null;

    /**
     * Property nacimiento
     */
    public $nacimiento = null;

    /**
     * Property pais
     */
    public $pais = null;

    /**
     * Property region
     */
    public $region = null;

    /**
     * Property sitio
     */
    public $sitio = null;

    /**
     * Property rut
     */
    public $rut = null;

    /**
     * Property youtube
     */
    public $youtube = null;

    /**
     * Property twitter
     */
    public $twitter = null;

    /**
     * Property facebook
     */
    public $facebook = null;

    /**
     * Property instagram
     */
    public $instagram = null;

    /**
     * Property expired_at
     */
    public $expired_at = null;

    /**
     * Property dias_restantes
     */
    public $dias_restantes = null;

    /**
     * Property attemps_login
     */
    public $attemps_login = '0';

    /**
     * Property active
     */
    public $active = null;

    /**
     * Property code_activate
     */
    public $code_activate = null;

    /**
     * Property code_expiration
     */
    public $code_expiration = null;

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
        $this->name = (!empty($data['name'])) ? $data['name']:null; //   varchar
        $this->email = (!empty($data['email'])) ? $data['email']:null; //   varchar
        $this->password = (!empty($data['password'])) ? $data['password']:null; //   varchar
        $this->deleted_at = (!empty($data['deleted_at'])) ? $data['deleted_at']:null; //   timestamp
        $this->remember_token = (!empty($data['remember_token'])) ? $data['remember_token']:null; //   varchar
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at']:null; //   timestamp
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at']:null; //   timestamp
        $this->descripcion = (!empty($data['descripcion'])) ? $data['descripcion']:null; //   varchar
        $this->avatar = (!empty($data['avatar'])) ? $data['avatar']:null; //   varchar
        $this->completa_datos = (!empty($data['completa_datos'])) ? $data['completa_datos']:null; //   tinyint
        $this->avatar_public = (!empty($data['avatar_public'])) ? $data['avatar_public']:null; //   varchar
        $this->apellido = (!empty($data['apellido'])) ? $data['apellido']:null; //   varchar
        $this->dirigido = (!empty($data['dirigido'])) ? $data['dirigido']:null; //   varchar
        $this->genero = (!empty($data['genero'])) ? $data['genero']:null; //   varchar
        $this->nacimiento = (!empty($data['nacimiento'])) ? $data['nacimiento']:null; //   date
        $this->pais = (!empty($data['pais'])) ? $data['pais']:null; //   varchar
        $this->region = (!empty($data['region'])) ? $data['region']:null; //   varchar
        $this->sitio = (!empty($data['sitio'])) ? $data['sitio']:null; //   varchar
        $this->rut = (!empty($data['rut'])) ? $data['rut']:null; //   varchar
        $this->youtube = (!empty($data['youtube'])) ? $data['youtube']:null; //   varchar
        $this->twitter = (!empty($data['twitter'])) ? $data['twitter']:null; //   varchar
        $this->facebook = (!empty($data['facebook'])) ? $data['facebook']:null; //   varchar
        $this->instagram = (!empty($data['instagram'])) ? $data['instagram']:null; //   varchar
        $this->expired_at = (!empty($data['expired_at'])) ? $data['expired_at']:null; //   datetime
        $this->dias_restantes = (!empty($data['dias_restantes'])) ? $data['dias_restantes']:null; //   int
        $this->attemps_login = (!empty($data['attemps_login'])) ? $data['attemps_login']:null; //  0 int
        $this->active = (!empty($data['active'])) ? $data['active']:null; //   tinyint
        $this->code_activate = (!empty($data['code_activate'])) ? $data['code_activate']:null; //   varchar
        $this->code_expiration = (!empty($data['code_expiration'])) ? $data['code_expiration']:null; //   timestamp
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


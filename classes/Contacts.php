<?php

class Contacts
{

    /**
     * Property id
     */
    public $id = null;

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
     * Property salutation
     */
    public $salutation = null;

    /**
     * Property first_name
     */
    public $first_name = null;

    /**
     * Property last_name
     */
    public $last_name = null;

    /**
     * Property title
     */
    public $title = null;

    /**
     * Property photo
     */
    public $photo = null;

    /**
     * Property department
     */
    public $department = null;

    /**
     * Property do_not_call
     */
    public $do_not_call = '0';

    /**
     * Property phone_home
     */
    public $phone_home = null;

    /**
     * Property phone_mobile
     */
    public $phone_mobile = null;

    /**
     * Property phone_work
     */
    public $phone_work = null;

    /**
     * Property phone_other
     */
    public $phone_other = null;

    /**
     * Property phone_fax
     */
    public $phone_fax = null;

    /**
     * Property primary_address_street
     */
    public $primary_address_street = null;

    /**
     * Property primary_address_city
     */
    public $primary_address_city = null;

    /**
     * Property primary_address_state
     */
    public $primary_address_state = null;

    /**
     * Property primary_address_postalcode
     */
    public $primary_address_postalcode = null;

    /**
     * Property primary_address_country
     */
    public $primary_address_country = null;

    /**
     * Property alt_address_street
     */
    public $alt_address_street = null;

    /**
     * Property alt_address_city
     */
    public $alt_address_city = null;

    /**
     * Property alt_address_state
     */
    public $alt_address_state = null;

    /**
     * Property alt_address_postalcode
     */
    public $alt_address_postalcode = null;

    /**
     * Property alt_address_country
     */
    public $alt_address_country = null;

    /**
     * Property assistant
     */
    public $assistant = null;

    /**
     * Property assistant_phone
     */
    public $assistant_phone = null;

    /**
     * Property lead_source
     */
    public $lead_source = null;

    /**
     * Property reports_to_id
     */
    public $reports_to_id = null;

    /**
     * Property birthdate
     */
    public $birthdate = null;

    /**
     * Property campaign_id
     */
    public $campaign_id = null;

    /**
     * Property joomla_account_id
     */
    public $joomla_account_id = null;

    /**
     * Property portal_account_disabled
     */
    public $portal_account_disabled = null;

    /**
     * Property portal_user_type
     */
    public $portal_user_type = 'Single';

    /**
     * Property vip
     */
    public $vip = null;

    /**
     * Property origen
     */
    public $origen = null;

    /**
     * Property digito_verificador
     */
    public $digito_verificador = null;

    /**
     * Property rutdv
     */
    public $rutdv = null;

    /**
     * Property saludo_cumpleanos
     */
    public $saludo_cumpleanos = null;

    /**
     * Property tipo_doc
     */
    public $tipo_doc = null;

    /**
     * Property plantilla_cumpleanos
     */
    public $plantilla_cumpleanos = null;

    /**
     * Property lawful_basis
     */
    public $lawful_basis = null;

    /**
     * Property date_reviewed
     */
    public $date_reviewed = null;

    /**
     * Property lawful_basis_source
     */
    public $lawful_basis_source = null;

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
        $this->date_entered = (!empty($data['date_entered'])) ? $data['date_entered']:null; //   datetime
        $this->date_modified = (!empty($data['date_modified'])) ? $data['date_modified']:null; //   datetime
        $this->modified_user_id = (!empty($data['modified_user_id'])) ? $data['modified_user_id']:null; //   char
        $this->created_by = (!empty($data['created_by'])) ? $data['created_by']:null; //   char
        $this->description = (!empty($data['description'])) ? $data['description']:null; //   text
        $this->deleted = (!empty($data['deleted'])) ? $data['deleted']:null; //  0 tinyint
        $this->assigned_user_id = (!empty($data['assigned_user_id'])) ? $data['assigned_user_id']:null; //   char
        $this->salutation = (!empty($data['salutation'])) ? $data['salutation']:null; //   varchar
        $this->first_name = (!empty($data['first_name'])) ? $data['first_name']:null; //   varchar
        $this->last_name = (!empty($data['last_name'])) ? $data['last_name']:null; //   varchar
        $this->title = (!empty($data['title'])) ? $data['title']:null; //   varchar
        $this->photo = (!empty($data['photo'])) ? $data['photo']:null; //   varchar
        $this->department = (!empty($data['department'])) ? $data['department']:null; //   varchar
        $this->do_not_call = (!empty($data['do_not_call'])) ? $data['do_not_call']:null; //  0 tinyint
        $this->phone_home = (!empty($data['phone_home'])) ? $data['phone_home']:null; //   varchar
        $this->phone_mobile = (!empty($data['phone_mobile'])) ? $data['phone_mobile']:null; //   varchar
        $this->phone_work = (!empty($data['phone_work'])) ? $data['phone_work']:null; //   varchar
        $this->phone_other = (!empty($data['phone_other'])) ? $data['phone_other']:null; //   varchar
        $this->phone_fax = (!empty($data['phone_fax'])) ? $data['phone_fax']:null; //   varchar
        $this->primary_address_street = (!empty($data['primary_address_street'])) ? $data['primary_address_street']:null; //   varchar
        $this->primary_address_city = (!empty($data['primary_address_city'])) ? $data['primary_address_city']:null; //   varchar
        $this->primary_address_state = (!empty($data['primary_address_state'])) ? $data['primary_address_state']:null; //   varchar
        $this->primary_address_postalcode = (!empty($data['primary_address_postalcode'])) ? $data['primary_address_postalcode']:null; //   varchar
        $this->primary_address_country = (!empty($data['primary_address_country'])) ? $data['primary_address_country']:null; //   varchar
        $this->alt_address_street = (!empty($data['alt_address_street'])) ? $data['alt_address_street']:null; //   varchar
        $this->alt_address_city = (!empty($data['alt_address_city'])) ? $data['alt_address_city']:null; //   varchar
        $this->alt_address_state = (!empty($data['alt_address_state'])) ? $data['alt_address_state']:null; //   varchar
        $this->alt_address_postalcode = (!empty($data['alt_address_postalcode'])) ? $data['alt_address_postalcode']:null; //   varchar
        $this->alt_address_country = (!empty($data['alt_address_country'])) ? $data['alt_address_country']:null; //   varchar
        $this->assistant = (!empty($data['assistant'])) ? $data['assistant']:null; //   varchar
        $this->assistant_phone = (!empty($data['assistant_phone'])) ? $data['assistant_phone']:null; //   varchar
        $this->lead_source = (!empty($data['lead_source'])) ? $data['lead_source']:null; //   varchar
        $this->reports_to_id = (!empty($data['reports_to_id'])) ? $data['reports_to_id']:null; //   char
        $this->birthdate = (!empty($data['birthdate'])) ? $data['birthdate']:null; //   date
        $this->campaign_id = (!empty($data['campaign_id'])) ? $data['campaign_id']:null; //   char
        $this->joomla_account_id = (!empty($data['joomla_account_id'])) ? $data['joomla_account_id']:null; //   varchar
        $this->portal_account_disabled = (!empty($data['portal_account_disabled'])) ? $data['portal_account_disabled']:null; //   tinyint
        $this->portal_user_type = (!empty($data['portal_user_type'])) ? $data['portal_user_type']:null; //  Single varchar
        $this->vip = (!empty($data['vip'])) ? $data['vip']:null; //   varchar
        $this->origen = (!empty($data['origen'])) ? $data['origen']:null; //   varchar
        $this->digito_verificador = (!empty($data['digito_verificador'])) ? $data['digito_verificador']:null; //   varchar
        $this->rutdv = (!empty($data['rutdv'])) ? $data['rutdv']:null; //   char
        $this->saludo_cumpleanos = (!empty($data['saludo_cumpleanos'])) ? $data['saludo_cumpleanos']:null; //   tinyint
        $this->tipo_doc = (!empty($data['tipo_doc'])) ? $data['tipo_doc']:null; //   varchar
        $this->plantilla_cumpleanos = (!empty($data['plantilla_cumpleanos'])) ? $data['plantilla_cumpleanos']:null; //   varchar
        $this->lawful_basis = (!empty($data['lawful_basis'])) ? $data['lawful_basis']:null; //   text
        $this->date_reviewed = (!empty($data['date_reviewed'])) ? $data['date_reviewed']:null; //   date
        $this->lawful_basis_source = (!empty($data['lawful_basis_source'])) ? $data['lawful_basis_source']:null; //   varchar
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


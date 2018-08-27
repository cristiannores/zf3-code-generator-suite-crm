<?php

class Leads
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
     * Property converted
     */
    public $converted = '0';

    /**
     * Property refered_by
     */
    public $refered_by = null;

    /**
     * Property lead_source
     */
    public $lead_source = null;

    /**
     * Property lead_source_description
     */
    public $lead_source_description = null;

    /**
     * Property status
     */
    public $status = null;

    /**
     * Property status_description
     */
    public $status_description = null;

    /**
     * Property reports_to_id
     */
    public $reports_to_id = null;

    /**
     * Property account_name
     */
    public $account_name = null;

    /**
     * Property account_description
     */
    public $account_description = null;

    /**
     * Property contact_id
     */
    public $contact_id = null;

    /**
     * Property account_id
     */
    public $account_id = null;

    /**
     * Property opportunity_id
     */
    public $opportunity_id = null;

    /**
     * Property opportunity_name
     */
    public $opportunity_name = null;

    /**
     * Property opportunity_amount
     */
    public $opportunity_amount = null;

    /**
     * Property campaign_id
     */
    public $campaign_id = null;

    /**
     * Property birthdate
     */
    public $birthdate = null;

    /**
     * Property portal_name
     */
    public $portal_name = null;

    /**
     * Property portal_app
     */
    public $portal_app = null;

    /**
     * Property website
     */
    public $website = null;

    /**
     * Property ip_registro
     */
    public $ip_registro = null;

    /**
     * Property digito_verificador
     */
    public $digito_verificador = null;

    /**
     * Property destino
     */
    public $destino = null;

    /**
     * Property rol_pasajero
     */
    public $rol_pasajero = null;

    /**
     * Property birthday
     */
    public $birthday = null;

    /**
     * Property pasaporte
     */
    public $pasaporte = null;

    /**
     * Property email1
     */
    public $email1 = null;

    /**
     * Property numero_negocio
     */
    public $numero_negocio = null;

    /**
     * Property comentario_presencial
     */
    public $comentario_presencial = null;

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
        $this->converted = (!empty($data['converted'])) ? $data['converted']:null; //  0 tinyint
        $this->refered_by = (!empty($data['refered_by'])) ? $data['refered_by']:null; //   varchar
        $this->lead_source = (!empty($data['lead_source'])) ? $data['lead_source']:null; //   varchar
        $this->lead_source_description = (!empty($data['lead_source_description'])) ? $data['lead_source_description']:null; //   text
        $this->status = (!empty($data['status'])) ? $data['status']:null; //   varchar
        $this->status_description = (!empty($data['status_description'])) ? $data['status_description']:null; //   text
        $this->reports_to_id = (!empty($data['reports_to_id'])) ? $data['reports_to_id']:null; //   char
        $this->account_name = (!empty($data['account_name'])) ? $data['account_name']:null; //   varchar
        $this->account_description = (!empty($data['account_description'])) ? $data['account_description']:null; //   text
        $this->contact_id = (!empty($data['contact_id'])) ? $data['contact_id']:null; //   char
        $this->account_id = (!empty($data['account_id'])) ? $data['account_id']:null; //   char
        $this->opportunity_id = (!empty($data['opportunity_id'])) ? $data['opportunity_id']:null; //   char
        $this->opportunity_name = (!empty($data['opportunity_name'])) ? $data['opportunity_name']:null; //   varchar
        $this->opportunity_amount = (!empty($data['opportunity_amount'])) ? $data['opportunity_amount']:null; //   varchar
        $this->campaign_id = (!empty($data['campaign_id'])) ? $data['campaign_id']:null; //   char
        $this->birthdate = (!empty($data['birthdate'])) ? $data['birthdate']:null; //   date
        $this->portal_name = (!empty($data['portal_name'])) ? $data['portal_name']:null; //   varchar
        $this->portal_app = (!empty($data['portal_app'])) ? $data['portal_app']:null; //   varchar
        $this->website = (!empty($data['website'])) ? $data['website']:null; //   varchar
        $this->ip_registro = (!empty($data['ip_registro'])) ? $data['ip_registro']:null; //   varchar
        $this->digito_verificador = (!empty($data['digito_verificador'])) ? $data['digito_verificador']:null; //   varchar
        $this->destino = (!empty($data['destino'])) ? $data['destino']:null; //   varchar
        $this->rol_pasajero = (!empty($data['rol_pasajero'])) ? $data['rol_pasajero']:null; //   varchar
        $this->birthday = (!empty($data['birthday'])) ? $data['birthday']:null; //   varchar
        $this->pasaporte = (!empty($data['pasaporte'])) ? $data['pasaporte']:null; //   varchar
        $this->email1 = (!empty($data['email1'])) ? $data['email1']:null; //   varchar
        $this->numero_negocio = (!empty($data['numero_negocio'])) ? $data['numero_negocio']:null; //   varchar
        $this->comentario_presencial = (!empty($data['comentario_presencial'])) ? $data['comentario_presencial']:null; //   varchar
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


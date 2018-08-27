<?php

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class OauthClientsMapper
{

    protected $adapter = null;

    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Method to save oauth_clients
     */
    public function store($data)
    {
        $data = ($data instanceof OauthClients) ? (array) $data : (array) $this->setObjectData($data);
        $sql = new Sql($this->adapter);
        $insert = new Insert('oauth_clients');
        $insert->values($data);
        $result = $sql->prepareStatementForSqlObject($insert)->execute();
        if ($result->getAffectedRows() === 0) {
        	return false;
        } else {
        	return $sql->getAdapter()->getDriver()->getLastGeneratedValue();
        }
    }

    /**
     * Method to update oauth_clients
     */
    public function update($data, $id)
    {
        $data = ($data instanceof OauthClients) ? (array) $data : (array) $this->setObjectData($data);
        unset($data['id']);
        $sql = new Sql($this->adapter);
        $update = new Update('oauth_clients');
        $update->set($data);
        $update->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($update)->execute();
        return $result->getAffectedRows();
    }

    /**
     * Method to delete oauth_clients
     */
    public function delete($id, $softDelete = true)
    {
        $sql = new Sql($this->adapter);
        $delete = new Delete('oauth_clients');
        $delete->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($delete)->execute();
        return $result->getAffectedRows();
    }

    /**
     * Method to get oauth_clients
     */
    public function get($id)
    {
        $sql = new Sql($this->adapter);
        $select = new Select('oauth_clients');
        $select->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        if ( $result->count() > 0){
        	return $this->setObjectData($result->current());
        }else{
        	return false;
        }
    }

    /**
     * Method to get all oauth_clients
     */
    public function getAll()
    {
        $sql = new Sql($this->adapter);
        $select = new Select('oauth_clients');
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet();
        	$resultSet->setHydrator(new ObjectProperty());
        	$resultSet->setObjectPrototype(new OauthClients());
        	$resultSet->initialize($result);
        	return $resultSet;
        } else {
        	return false;
        }
    }

    /**
     * Return instance of OauthClients
     */
    public function setObjectData($data)
    {
        $oauth_clients = new OauthClients();
        $oauth_clients->exchangeArray($data);
        return $oauth_clients;
    }


}


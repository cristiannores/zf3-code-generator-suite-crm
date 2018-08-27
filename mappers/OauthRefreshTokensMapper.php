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

class OauthRefreshTokensMapper
{

    protected $adapter = null;

    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Method to save oauth_refresh_tokens
     */
    public function store($data)
    {
        $data = ($data instanceof OauthRefreshTokens) ? (array) $data : (array) $this->setObjectData($data);
        $sql = new Sql($this->adapter);
        $insert = new Insert('oauth_refresh_tokens');
        $insert->values($data);
        $result = $sql->prepareStatementForSqlObject($insert)->execute();
        if ($result->getAffectedRows() === 0) {
        	return false;
        } else {
        	return $sql->getAdapter()->getDriver()->getLastGeneratedValue();
        }
    }

    /**
     * Method to update oauth_refresh_tokens
     */
    public function update($data, $id)
    {
        $data = ($data instanceof OauthRefreshTokens) ? (array) $data : (array) $this->setObjectData($data);
        unset($data['id']);
        $sql = new Sql($this->adapter);
        $update = new Update('oauth_refresh_tokens');
        $update->set($data);
        $update->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($update)->execute();
        return $result->getAffectedRows();
    }

    /**
     * Method to delete oauth_refresh_tokens
     */
    public function delete($id, $softDelete = true)
    {
        $sql = new Sql($this->adapter);
        $delete = new Delete('oauth_refresh_tokens');
        $delete->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($delete)->execute();
        return $result->getAffectedRows();
    }

    /**
     * Method to get oauth_refresh_tokens
     */
    public function get($id)
    {
        $sql = new Sql($this->adapter);
        $select = new Select('oauth_refresh_tokens');
        $select->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        if ( $result->count() > 0){
        	return $this->setObjectData($result->current());
        }else{
        	return false;
        }
    }

    /**
     * Method to get all oauth_refresh_tokens
     */
    public function getAll()
    {
        $sql = new Sql($this->adapter);
        $select = new Select('oauth_refresh_tokens');
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet();
        	$resultSet->setHydrator(new ObjectProperty());
        	$resultSet->setObjectPrototype(new OauthRefreshTokens());
        	$resultSet->initialize($result);
        	return $resultSet;
        } else {
        	return false;
        }
    }

    /**
     * Return instance of OauthRefreshTokens
     */
    public function setObjectData($data)
    {
        $oauth_refresh_tokens = new OauthRefreshTokens();
        $oauth_refresh_tokens->exchangeArray($data);
        return $oauth_refresh_tokens;
    }


}


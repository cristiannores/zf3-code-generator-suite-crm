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

class NotificationsMapper
{

    protected $adapter = null;

    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Method to save notifications
     */
    public function store($data)
    {
        $data = ($data instanceof Notifications) ? (array) $data : (array) $this->setObjectData($data);
        $sql = new Sql($this->adapter);
        $insert = new Insert('notifications');
        $insert->values($data);
        $result = $sql->prepareStatementForSqlObject($insert)->execute();
        if ($result->getAffectedRows() === 0) {
        	return false;
        } else {
        	return $sql->getAdapter()->getDriver()->getLastGeneratedValue();
        }
    }

    /**
     * Method to update notifications
     */
    public function update($data, $id)
    {
        $data = ($data instanceof Notifications) ? (array) $data : (array) $this->setObjectData($data);
        unset($data['id']);
        $sql = new Sql($this->adapter);
        $update = new Update('notifications');
        $update->set($data);
        $update->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($update)->execute();
        return $result->getAffectedRows();
    }

    /**
     * Method to delete notifications
     */
    public function delete($id, $softDelete = true)
    {
        $sql = new Sql($this->adapter);
        $delete = new Delete('notifications');
        $delete->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($delete)->execute();
        return $result->getAffectedRows();
    }

    /**
     * Method to get notifications
     */
    public function get($id)
    {
        $sql = new Sql($this->adapter);
        $select = new Select('notifications');
        $select->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        if ( $result->count() > 0){
        	return $this->setObjectData($result->current());
        }else{
        	return false;
        }
    }

    /**
     * Method to get all notifications
     */
    public function getAll()
    {
        $sql = new Sql($this->adapter);
        $select = new Select('notifications');
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet();
        	$resultSet->setHydrator(new ObjectProperty());
        	$resultSet->setObjectPrototype(new Notifications());
        	$resultSet->initialize($result);
        	return $resultSet;
        } else {
        	return false;
        }
    }

    /**
     * Return instance of Notifications
     */
    public function setObjectData($data)
    {
        $notifications = new Notifications();
        $notifications->exchangeArray($data);
        return $notifications;
    }


}


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

class OpportunitiesMapper
{

    protected $adapter = null;

    protected $id = null;

    protected $now = null;

    public function __construct($adapter)
    {
        $this->adapter = $adapter;
        $date_now_utc = (new \DateTime( 'now',  new \DateTimeZone( 'UTC' ) ));
        $this->now = $date_now_utc->format('Y-m-d h:i:s');
    }

    /**
     * Method to save opportunities
     */
    public function store($data)
    {
        $this->generateId();
        $data_table = ($data instanceof Opportunities) ? (array) $data : (array) $this->setObjectData($data);
        $data_table = $this->generateSetDefaultInsertValues($data);
        $data_table['id'] = $this->id;

        $sql = new Sql($this->adapter);

        $insert = new Insert('opportunities');
        $insert->values($data_table);
        $result = $sql->prepareStatementForSqlObject($insert)->execute();
        if ($result->getAffectedRows() === 0) {
        	return false;
        }

        // Generating insert in table cstm
        $data_table_cstm = ($data instanceof OpportunitiesCstm) ? (array) $data : (array) $this->setObjectDataCstm($data);
        $data_table_cstm['id_c'] = $this->id;
        $insert = new Insert('opportunities_cstm');
        $insert->values($data_table_cstm);
        $result_cstm = $sql->prepareStatementForSqlObject($insert)->execute();
        if ($result_cstm->getAffectedRows() === 0) {
        	return false;
        }

        return $this->id;
    }

    /**
     * Method to update opportunities
     */
    public function update($data, $id)
    {
        $data_table = ($data instanceof Opportunities) ? (array) $data : (array) $this->setObjectData($data);
        unset($data_table['id']);
        $data_table = $this->unsetNullsInUpdate($data_table);
        $sql = new Sql($this->adapter);
        $update = new Update('opportunities');
        $update->set($data_table);
        $update->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($update)->execute();

        $data_table_cstm = ($data instanceof OpportunitiesCstm) ? (array) $data : (array) $this->setObjectDataCstm($data);
        $data_table_cstm['id_c']= $id;
        $data_table_cstm = $this->unsetNullsInUpdate($data_table_cstm);
        $sql = new Sql($this->adapter);
        $update = new Update('opportunities_cstm');
        $update->set($data_table_cstm);
        $update->where(['id_c' => $id]);
        $result_cstm = $sql->prepareStatementForSqlObject($update)->execute();
        return $result->getAffectedRows();
    }

    /**
     * Method to delete opportunities
     */
    public function delete($id, $softDelete = true)
    {
        $sql = new Sql($this->adapter);
        if ( !$softDelete){
        	$delete = new Delete('opportunities');
        	$delete->where(['id' => $id]);
        	$result = $sql->prepareStatementForSqlObject($delete)->execute();

        	$delete_cstm = new Delete('opportunities_cstm');
        	$delete_cstm->where(['id_c' => $id]);
        	$result_cstm = $sql->prepareStatementForSqlObject($delete_cstm)->execute();
        	return $result->getAffectedRows();
        } else { 

        	$delete_soft = new Update('opportunities');
        	$delete_soft->set(['deleted' => 1]);
        	$delete_soft->where(['id' => $id]);
        	$result = $sql->prepareStatementForSqlObject($delete_soft)->execute();
        	return $result->getAffectedRows();
        }
    }

    /**
     * Method to get opportunities
     */
    public function get($id)
    {
        $sql = new Sql($this->adapter);
        $select = new Select('opportunities');
        $select->where(['id' => $id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        if ( $result->count() > 0){
        	$result = (array) $this->setObjectData($result->current());
        }else{
        	return false;
        }
        $select_cstm = new Select('opportunities_cstm');
        $select_cstm->where(['id_c' => $id]);
        $result_cstm = $sql->prepareStatementForSqlObject($select_cstm)->execute();
        if ( $result_cstm->count() > 0){
        	$result_cstm = (array) $this->setObjectDataCstm($result_cstm->current());
        }else{
        	return false;
        }
        return array_merge($result, $result_cstm);
    }

    /**
     * Method to get all opportunities
     */
    public function getAll()
    {
        $sql = new Sql($this->adapter);
        $select = new Select('opportunities');
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet();
        	$resultSet->setHydrator(new ObjectProperty());
        	$resultSet->setObjectPrototype(new Opportunities());
        	$resultSet->initialize($result);
        	return $resultSet;
        } else {
        	return false;
        }
    }

    /**
     * Return instance of Opportunities
     */
    public function setObjectData($data)
    {
        $data = (array) $data;
        $opportunities = new Opportunities();
        $opportunities->exchangeArray($data);
        return $opportunities;
    }

    /**
     * Return instance of OpportunitiesCstm
     */
    public function setObjectDataCstm($data)
    {
        $data = (array) $data;
        $opportunities_cstm = new OpportunitiesCstm();
        $opportunities_cstm->exchangeArray($data);
        return $opportunities_cstm;
    }

    /**
     * Generate an id forOpportunities
     */
    public function generateId()
    {
        $this->id = create_guid();
    }

    /**
     * Generate default Values for insert Opportunities
     */
    public function generateSetDefaultInsertValues($data)
    {
        $data = $this->setObjectData($data);
        $data->date_entered = $this->now;
        $data->date_modified = $this->now;
        $data->deleted = 0;
        return (array) $data;
    }

    /**
     * Generate an id forOpportunities
     */
    public function unsetNullsInUpdate(&$data)
    {
        foreach ($data as $key => $value) {
        	if ($value === null) {
        		 unset($data[$key]);
        	}
        }
          return $data;
    }


}


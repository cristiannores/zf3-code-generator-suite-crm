<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Database {

    private $adapter;

    public function __construct() {
        $this->setAdapter();
    }

    public function setAdapter($driver = null) {

        if (!$driver) {
            $this->adapter = new Zend\Db\Adapter\Adapter([
                 'driver' => 'Pdo',
                'dsn'    => 'mysql:dbname=crm;host=percona-db-desa;charset=utf8',
                
                'username' => 'crm',
                'password' => '.C0ch4.1234', 
                'options' => array(
                    'buffer_results' => true,
            )]);
        } else {
            $this->adapter = new Zend\Db\Adapter\Adapter($driver);
        }
    }

    public function getAdapter(): Zend\Db\Adapter\Adapter {
        return $this->adapter;
    }

}

<?php

ini_set('memory_limit', '1024M'); // or you could use 1G
echo "hola";
exit;
use Zend\Debug\Debug;

require __DIR__ . './core/core.php';

$testing = new DatabaseTest();

$result = $testing->testGetAllSuite();

exit;

$data = new stdClass();
$data->first_name = 'Cristian2';
$data->last_name = 'Nores';
$data->email = 'Nores';
$data->rut = '8010360-3';
$data->nacionalidad = 'Chilena';
$data->passport_first_name_c = 'PASSPORT FIRST NAME';
$data->passport_last_name_c = 'PASSPORT LAST NAME';
$data->gender_c = 'GENDER C';
$data->passport_obtaining_date_c = (new DateTime('NOW'))->format('Y-m-d');
$data->passport_expiration_date_c = (new DateTime('NOW'))->format('Y-m-d');
$data->emergency_name_c = 'EMERGENCY NAME';
$data->emergency_phone_c = 'EMERGENCY PHONE';
$data->emergency_relationship_c = 'EMERGENCY RELATIONSHIP';
$data->company_rut_c = 'COMPANY RUT';
$data->vip_c = 1;





$database = new Database();
$adapter = $database->getAdapter();

if ($adapter instanceof \Zend\Db\Adapter\Adapter) { //Checking adapter..
    try {
        // loading mapers
        $contactMapper = new ContactsMapper($adapter);
        $foidMapper = new FpFoidMapper($adapter);
        $leadMapper = new LeadsMapper($adapter);
        // Busco el contacto antes de la transaccion
        $contacto_db = $contactMapper->searchOne(['documento' => $data->rut, 'tipo_documento' => 'rut']);

        // Setting default values 
        $data->lead_source = 'CRDB';

        if (isset($contacto_db['id'])) {// Contacto existe actualizo datos
            Debug::dump('Existe contacto');
            $adapter->getDriver()->getConnection()->beginTransaction();
            Debug::dump('lala');
            $update_contact = $contactMapper->update($data, $contacto_db['id']);
            Debug::dump('lala');
            $data->documento = $data->rut;
            $data->tipo_documento = 'rut';

            $update_foid = $foidMapper->update($data, $contacto_db['fp_foid_id']);
            Debug::dump('lala');

            Debug::dump($update_contact);
            Debug::dump($update_foid);
            if ($update_contact || $update_foid) {

                $adapter->getDriver()->getConnection()->commit();
                $result = ['contact' => $contactMapper->get($contacto_db['id']), 'foid' => $contacto_db['fp_foid_id'], 'msg' => 'contacto actualizado'];
                Debug::dump($result);
            } else {
                $adapter->getDriver()->getConnection()->rollback();
                $result = ['contact' => $contactMapper->get($contacto_db['id']), 'foid' => $foidMapper->get($contacto_db['fp_foid_id']), 'msg' => 'Nada que actualizar'];
                Debug::dump($result);
            }
        } else { // Contacto no existe.
            Debug::dump('No existe contacto');
            $adapter->getDriver()->getConnection()->beginTransaction();

            $create_contact = $contactMapper->store($data);
            $data->documento = $data->rut;
            $data->tipo_documento = 'rut';
            $create_foid = $foidMapper->store($data);
            $create_assignment_foid_contact = $foidMapper->assignContact($create_contact, $create_foid);
//
            if ($create_contact && $create_foid && $create_assignment_foid_contact) {
                $adapter->getDriver()->getConnection()->commit();
                $result = ['contact' => $contactMapper->get($create_contact), 'foid' => $foidMapper->get($create_foid), 'msg' => 'contacto creado'];
                Debug::dump($result);
            } else {
                $adapter->getDriver()->getConnection()->rollback();
                Debug::dump('No insertado');
            }
        }
    } catch (Exception $ex) {
        $adapter->getDriver()->getConnection()->rollback();
        Debug::dump($ex->getMessage());
        return ['error' => $ex->getMessage()];
    } catch (\Zend\Db\Adapter\Exception\ErrorException $ex) {
        $adapter->getDriver()->getConnection()->rollback();
        Debug::dump($ex->getMessage());
        return false;
    } catch (Zend\Db\Adapter\Exception\RuntimeException $ex) {
        $adapter->getDriver()->getConnection()->rollback();
        Debug::dump($ex->getMessage());
        return false;
    }
}
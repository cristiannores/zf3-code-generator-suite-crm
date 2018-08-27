<?php

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Debug\Debug;
use Zend\Hydrator\ObjectProperty;

class DatabaseTest {

    protected $adapter;

    public function __construct() {

        $db = new Database();
        $this->adapter = $db->getAdapter();
    }

    public function testInsertSuite() {

        $data = [];
        $data['first_name'] = uniqid();
        $data['last_name'] = uniqid();
        $data['assigned_user_id'] = 'Testing';
        $data['assigned_user_id'] = 0;
        $data['lead_source'] = 'TESTING_CRM_MAPPER';

        $contactMapper = new ContactsMapper($this->adapter);
        $result = $contactMapper->store($data);
        Debug::dump($result);
    }

    public function testGetAllSuite() {
        $contactMapper = new ContactsMapper($this->adapter);
        $result = $contactMapper->getAll();
        foreach($result as $r){
            
            
            Debug::dump($r);
        }
    }

    public function testGetSuite($id) {
        $contactMapper = new ContactsMapper($this->adapter);
        $result = $contactMapper->get($id);
        Debug::dump($result);
    }

    public function testDeleteSuite($id, $soft = true) {


        $contactMapper = new ContactsMapper($this->adapter);
        $result = $contactMapper->delete($id, $soft);
        Debug::dump($result);
    }

    public function testUpdateSuite() {

        $data = [];
        $data['first_name'] = 'UP' . uniqid();
        $data['last_name'] = 'UP' . uniqid();
        $data['assigned_user_id'] = 'Testing';
        $data['assigned_user_id'] = 0;
        $data['lead_source'] = 'TESTING_CRM_MAPPER';

        $contactMapper = new ContactsMapper($this->adapter);
        $result = $contactMapper->update($data, '7ea18172-ac31-68b1-5e76-5b84156216d6');
        Debug::dump($result);
    }

    public function testInsertMultiple() {
        $statement = $this->adapter->createStatement('INSERT INTO CURSOS (nombre, descripcion) VALUES (:uno, :dos)');
        $statement->prepare();
        $result = $statement->execute([':uno' => 'hola', ':dos' => 'description']);
        Debug::dump($result);
    }

    public function test() {
        $statement = $this->adapter->createStatement('Select * from actividades');
        $statement->prepare([]);
        $result = $statement->execute();
        $resultSet = new HydratingResultSet();

        $resultSet->setHydrator(new ObjectProperty());
        $resultSet->setObjectPrototype(new Actividades());
        $resultSet->initialize($result);

        foreach ($resultSet as $user) {
            if ($user instanceof Actividades) {
                Debug::dump($user->avatar);
            }
        }
    }

    public function testStore() {
        $curso = new Cursos();
        $curso->nombre = 'Un curso';
        $curso->descripcion = 'Una descripcion';

        $mapper = new CursosMapper($this->adapter);
        $result = $mapper->store($curso);
        if ($result) {
            Debug::dump('Insert in db ok . ID :' . $result . ' :-) !');
        } else {
            Debug::dump('Error to insert in db  :_(');
        }
    }

    public function testGetAll() {
        $actividades = new ActividadesMapper($this->adapter);
        $result = $actividades->getAll();
        foreach ($result as $key => $value) {
            Debug::dump($value);
        }
        $cursos = new CursosMapper($this->adapter);
        $result = $cursos->getAll();
        foreach ($result as $key => $value) {
            Debug::dump($value);
        }
    }

    public function testUpdate() {
        $curso = new Cursos();
        $curso->nombre = 'Un curso 1';
        $curso->descripcion = 'Una descripcion 11';

        $mapper = new CursosMapper($this->adapter);
        $result = $mapper->update($curso, 10);
        if ($result) {
            Debug::dump('Update realizado ' . $result . ' filas afectadas');
        } else {
            Debug::dump('Update realizado sin cambios');
        }
    }

    public function testDelete() {

        $mapper = new CursosMapper($this->adapter);
        $result = $mapper->delete(10);
        if ($result) {
            Debug::dump('Delete realizado ' . $result . ' filas afectadas');
        } else {
            Debug::dump('Delete realizado sin cambios');
        }
    }

    public function testGet() {

        $mapper = new ActividadesMapper($this->adapter);
        $result = $mapper->get(99);
        if ($result instanceof Actividades) {
            Debug::dump($result->nombre);
        }
    }

    public function testStoreActividad() {
        $actividad = new Actividades();
        $actividad->nombre = 'Una actividad';
        $actividad->descripcion = 'Una descripcion';
        $actividad->avatar = 'un avatar';
        $actividad->user_id = '67';
        $actividad->avatar_public = 'un avatar';

        $mapper = new ActividadesMapper($this->adapter);
        $result = $mapper->store($actividad);
        if ($result) {
            Debug::dump('Insert in db ok . ID :' . $result . ' :-) !');
        } else {
            Debug::dump('Error to insert in db  :_(');
        }
    }

}

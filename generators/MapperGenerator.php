<?php

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Object\ColumnObject;
use Zend\Db\Metadata\Source\Factory;

class MapperGenerator {

    protected $adapter;
    protected $metadata;
    protected $dir;
    protected $filesCreated = [];
    protected $actual_table;

    public function __construct($dir = __DIR__ . '/../mappers/') {
        $this->dir = $dir;
        $db = new Database();
        $this->adapter = $db->getAdapter();
        $this->metadata = Factory::createSourceFromAdapter($this->adapter);
    }

    public function generate() {

        $tableNames = $this->metadata->getTableNames();
        foreach ($tableNames as $tableName) {
            $this->actual_table = $tableName;
            $class = new ClassGenerator();
            $class->addProperty('adapter', null, PropertyGenerator::FLAG_PROTECTED);
            $class->setName($this->getCamelCase($tableName) . 'Mapper');            
            $class->addUse('Zend\Db\Adapter\Adapter');
            $class->addUse('Zend\Db\Adapter\Driver\ResultInterface');
            $class->addUse('Zend\Db\ResultSet\HydratingResultSet');
            $class->addUse('Zend\Hydrator\ObjectProperty');
            $class->addUse('Zend\Db\ResultSet\ResultSet');
            $class->addUse('Zend\Db\Sql\Delete');
            $class->addUse('Zend\Db\Sql\Insert');
            $class->addUse('Zend\Db\Sql\Select');
            $class->addUse('Zend\Db\Sql\Sql');
            $class->addUse('Zend\Db\Sql\Update');
                
            $table = $this->metadata->getTable($tableName);
            $properties = [];
            $bodyMethodExchangeArray = '';


            $this->checkIfDirExist();
            $class->addMethodFromGenerator($this->generateConstructorMethod());
            $class->addMethodFromGenerator($this->generateStoreMethod());
            $class->addMethodFromGenerator($this->generateUpdateMethod());
            $class->addMethodFromGenerator($this->generateDeleteMethod());
            $class->addMethodFromGenerator($this->generateGetMethod());
            $class->addMethodFromGenerator($this->generateGetAllMethod());
            $class->addMethodFromGenerator($this->generateSetObjectDataMethod());

            $file = $this->generateFile($tableName, $class);
            Zend\Debug\Debug::dump('Archivo generado');
            Zend\Debug\Debug::dump($file);

            $this->filesCreated[] = $file;
        }
        return $this->filesCreated;
    }

    private function generateConstructorMethod() {
        //Generating parameter
        $parameterAdapter = new \Zend\Code\Generator\ParameterGenerator();
        $parameterAdapter->setName('adapter');
        // Generating body
        $body = "\n";
        $body .= '$this->adapter = $adapter;';
        $body .= "\n";



        $method = new MethodGenerator();
        $method->setName('__construct');
        $method->setParameter($parameterAdapter);
        $method->setBody($body);


        return $method;
    }

    private function generateStoreMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$data = ($data instanceof ' . $this->getCamelCase($this->actual_table) . ') ? (array) $data : (array) $this->setObjectData($data);'
                . "\n"
                . '$sql = new Sql($this->adapter);'
                . "\n"
                . '$insert = new Insert(\'' . $this->actual_table . '\');'
                . "\n"
                . '$insert->values($data);'
                . "\n"
                . '$result = $sql->prepareStatementForSqlObject($insert)->execute();'
                . "\n"
                . 'if ($result->getAffectedRows() === 0) {'
                . "\n"
                . "\t" . 'return false;'
                . "\n"
                . '} else {'
                . "\n"
                . "\t" . 'return $sql->getAdapter()->getDriver()->getLastGeneratedValue();'
                . "\n"
                . '}';



        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('store');
        $method->setParameter('data');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Method to save ' . $this->actual_table,
                    'longDescription' => null,
        ]));
        $method->setVisibility($method::FLAG_PUBLIC);
        $method->setBody($body);
        return $method;
    }

    private function generateUpdateMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$data = ($data instanceof ' . $this->getCamelCase($this->actual_table) . ') ? (array) $data : (array) $this->setObjectData($data);'
                . "\n"
                . 'unset($data[\'id\']);'
                . "\n"
                . '$sql = new Sql($this->adapter);'
                . "\n"
                . '$update = new Update(\'' . $this->actual_table . '\');'
                . "\n"
                . '$update->set($data);'
                . "\n"
                . '$update->where([\'id\' => $id]);'
                . "\n"
                . '$result = $sql->prepareStatementForSqlObject($update)->execute();'
                . "\n"
                . 'return $result->getAffectedRows();'
        ;



        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('update');
        $method->setParameter('data');
        $method->setParameter('id');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Method to update ' . $this->actual_table,
                    'longDescription' => null,
        ]));
        $method->setVisibility($method::FLAG_PUBLIC);
        $method->setBody($body);
        return $method;
    }

    private function generateDeleteMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$sql = new Sql($this->adapter);'
                . "\n"
                . '$delete = new Delete(\'' . $this->actual_table . '\');'
                . "\n"
                . '$delete->where([\'id\' => $id]);'
                . "\n"
                . '$result = $sql->prepareStatementForSqlObject($delete)->execute();'
                . "\n"
                . 'return $result->getAffectedRows();'
        ;



        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('delete');
        $method->setParameter('id');

        // Parametro soft delete
        $parameter = new \Zend\Code\Generator\ParameterGenerator();
        $parameter->setName('softDelete');
        $valueGenerator = new Zend\Code\Generator\ValueGenerator();
        $valueGenerator->setType('boolean');
        $valueGenerator->setValue('false');
        $parameter->setDefaultValue($valueGenerator);


        $method->setParameter($parameter);
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Method to delete ' . $this->actual_table,
                    'longDescription' => null,
        ]));
        $method->setVisibility($method::FLAG_PUBLIC);
        $method->setBody($body);
        return $method;
    }

    private function generateGetMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$sql = new Sql($this->adapter);'
                . "\n"
                . '$select = new Select(\'' . $this->actual_table . '\');'
                . "\n"
                . '$select->where([\'id\' => $id]);'
                . "\n"
                . '$result = $sql->prepareStatementForSqlObject($select)->execute();'
                . "\n"
                . 'if ( $result->count() > 0){'
                . "\n"
                . "\t" . 'return $this->setObjectData($result->current());'
                . "\n"
                . '}else{'
                . "\n"
                . "\t" . 'return false;'
                . "\n"
                . '}'
        ;



        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('get');
        $method->setParameter('id');

        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Method to get ' . $this->actual_table,
                    'longDescription' => null,
        ]));
        $method->setVisibility($method::FLAG_PUBLIC);
        $method->setBody($body);
        return $method;
    }

    private function generateGetAllMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$sql = new Sql($this->adapter);'
                . "\n"
                . '$select = new Select(\'' . $this->actual_table . '\');'
                . "\n"
                . '$result = $sql->prepareStatementForSqlObject($select)->execute();'
                . "\n"
                . 'if ($result instanceof ResultInterface && $result->isQueryResult()) {'
                . "\n"
                . "\t".'$resultSet = new HydratingResultSet();'
                . "\n"
                . "\t".'$resultSet->setHydrator(new ObjectProperty());'
                . "\n"
                . "\t".'$resultSet->setObjectPrototype(new ' . $this->getCamelCase($this->actual_table) . '());'
                . "\n"
                . "\t".'$resultSet->initialize($result);'
                . "\n"
                . "\t".'return $resultSet;'
                . "\n"
                . '} else {'
                . "\n"
                . "\t".'return false;'
                . "\n"
                . '}'
        ;

        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('getAll');        

        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Method to get all ' . $this->actual_table,
                    'longDescription' => null,
        ]));
        $method->setVisibility($method::FLAG_PUBLIC);
        $method->setBody($body);
        return $method;
    }

    private function generateSetObjectDataMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$' . $this->actual_table . ' = new ' . $this->getCamelCase($this->actual_table) . '();'
                . "\n" . '$' . $this->actual_table . '->exchangeArray($data);'
                . "\n" . 'return $' . $this->actual_table . ';';

        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('setObjectData');
        $method->setParameter('data');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Return instance of ' . $this->getCamelCase($this->actual_table),
                    'longDescription' => null,
        ]));
        $method->setVisibility($method::FLAG_PRIVATE);
        $method->setBody($body);
        return $method;
    }

    private function checkIfDirExist() {

        if (!dir($this->dir)) {
            mkdir($this->dir);
        }
    }

    private function generateFile($fileName, $class) {

        $file = new FileGenerator();
        $file->setClass($class);
        @$model = $file->generate();
        $file_saved = $this->dir . $this->getCamelCase($fileName) . 'Mapper.php';
        file_put_contents($file_saved, $model);
        return $file_saved;
    }

    // Changing file_name to FileName
    private function getCamelCase($name) {
        $parts = explode('_', $name);
        foreach ($parts as $idx => $p) {
            $parts[$idx] = ucfirst($p);
        }
        $name = implode('', $parts);
        return $name;
    }

    private function checkDateTypeColumn($type) {
        $data = 'null';
        if ($type === 'timestamp') {
            $data = 'null';
        }
        return $data;
    }

}

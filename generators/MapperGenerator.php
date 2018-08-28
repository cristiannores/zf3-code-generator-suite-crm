<?php

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Object\ColumnObject;
use Zend\Db\Metadata\Source\Factory;
use Symfony\Component\Console\Output\OutputInterface;

class MapperGenerator {

    protected $adapter;
    protected $metadata;
    protected $dir;
    protected $filesCreated = [];
    protected $actual_table;
    protected $table_cstm_exists;
    protected $tables;
    protected $tablesAllowed;
    protected $restric_table = null;
    protected $output = null;
    protected $overwrite = false;

    public function __construct($overwrite = false) {

        $this->output = new \Symfony\Component\Console\Output\ConsoleOutput();

        $this->overwrite = $overwrite;
        $this->dir = $GLOBALS['suite_crm_path'] . '/custom/mappers/';
        $db = new Database();
        $this->adapter = $db->getAdapter();
        $this->metadata = Factory::createSourceFromAdapter($this->adapter);
        $this->getTablesToGenerate();
        $this->generateDirectory();
    }

    private function generateDirectory() {
        if (!file_exists($this->dir)) {
            mkdir($this->dir, 0777, true);
        }
        if (!file_exists($this->dir . 'base/')) {
            mkdir($this->dir . 'base/', 0777, true);
        }
    }

    public function setTable($table) {
        $this->restric_table = $table;
    }

    public function generate() {

        $this->tables = $this->metadata->getTableNames();


        foreach ($this->tables as $tableName) {


            // Salto las tablas cstm para la generacion de mappers
            if (substr($tableName, -5) === 'cstm') {
                continue;
            }
            // cheking if table cstm exists
            $this->table_cstm_exists = false;
            if (in_array($tableName . '_cstm', $this->tables)) {
                $this->table_cstm_exists = true;
            }

            // Restrict only for a table
            if ($this->restric_table !== null) {
                if ($this->restric_table !== $tableName) {
                    continue;
                }
            }

            $this->actual_table = $tableName;
            $class = new ClassGenerator();
            $class->addProperty('adapter', null, PropertyGenerator::FLAG_PROTECTED);
            $class->addProperty('id', null, PropertyGenerator::FLAG_PROTECTED);
            $class->addProperty('now', null, PropertyGenerator::FLAG_PROTECTED);
            $class->setName($this->getCamelCase($tableName) . 'MapperBase');
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



            $class->addMethodFromGenerator($this->generateConstructorMethod());
            $class->addMethodFromGenerator($this->generateStoreMethod());
            $class->addMethodFromGenerator($this->generateUpdateMethod());
            $class->addMethodFromGenerator($this->generateDeleteMethod());
            $class->addMethodFromGenerator($this->generateGetMethod());
            $class->addMethodFromGenerator($this->generateGetAllMethod());
            $class->addMethodFromGenerator($this->generateSetObjectDataMethod());
            if ($this->table_cstm_exists) {
                $class->addMethodFromGenerator($this->generateSetObjectDataCstmMethod());
            }
            $class->addMethodFromGenerator($this->generateGenerateIdMethod());

            $columns = $this->metadata->getTable($tableName)->getColumns();
            $class->addMethodFromGenerator($this->generateSetDefaultInsertValues($columns));
            $class->addMethodFromGenerator($this->generateUnsetNullsInUpdate());

            $file = $this->generateFile($tableName, $class);
            $this->output->writeln('Archivo generado : ' . $file);



            $file = $this->generateMapper();
            if ($file) {
                $this->output->writeln('Archivo generado : ' . $file);
            }


            $this->filesCreated[] = $file;
        }

        return $this->filesCreated;
    }

    private function generateMapper() {

        $bodyConstructor = ''
                . "\n"
                . 'parent::__construct($adapter);'
                . "\n"
        ;

        $constructorMethod = new MethodGenerator();
        $constructorMethod->setName('__construct');
        $constructorMethod->setParameter('adapter');
        $constructorMethod->setBody($bodyConstructor);

        $class = new ClassGenerator();
        $class->setName($this->getCamelCase($this->actual_table) . 'Mapper');
        $class->addMethodFromGenerator($constructorMethod);
        $class->setExtendedClass($this->getCamelCase($this->actual_table) . 'MapperBase');



        $file = new FileGenerator();
        $file->setClass($class);
        @$model = $file->generate();
        $file_saved = $this->dir . '' . $this->getCamelCase($this->actual_table) . 'Mapper.php';

        if (file_exists($file_saved)) {
            
            if ($this->overwrite) {
                file_put_contents($file_saved, $model);
                return $file_saved;
            }
        } else {
            Zend\Debug\Debug::dump('no existe');
            file_put_contents($file_saved, $model);
            return $file_saved;
        }


        return false;
    }

    private function generateConstructorMethod() {
        //Generating parameter
        $parameterAdapter = new \Zend\Code\Generator\ParameterGenerator();
        $parameterAdapter->setName('adapter');
        // Generating body
        $body = "\n"
                . '$this->adapter = $adapter;'
                . "\n"
                . '$date_now_utc = (new \DateTime( \'now\',  new \DateTimeZone( \'UTC\' ) ));'
                . "\n"
                . '$this->now = $date_now_utc->format(\'Y-m-d h:i:s\');'
                . "\n"
        ;




        $method = new MethodGenerator();
        $method->setName('__construct');
        $method->setParameter($parameterAdapter);
        $method->setBody($body);


        return $method;
    }

    private function generateStoreMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$this->generateId();'
                . "\n"
                . '$data_table = ($data instanceof ' . $this->getCamelCase($this->actual_table) . ') ? (array) $data : (array) $this->setObjectData($data);'
                . "\n"
                . '$data_table = $this->generateSetDefaultInsertValues($data);'
                . "\n"
                . '$data_table[\'id\'] = $this->id;'
                . "\n"
                . "\n"
                . '$sql = new Sql($this->adapter);'
                . "\n"
                . "\n"
                . '$insert = new Insert(\'' . $this->actual_table . '\');'
                . "\n"
                . '$insert->values($data_table);'
                . "\n"
                . '$result = $sql->prepareStatementForSqlObject($insert)->execute();'
                . "\n"
                . 'if ($result->getAffectedRows() === 0) {'
                . "\n"
                . "\t" . 'return false;'
                . "\n"
                . '}';

        if ($this->table_cstm_exists) {
            $body .= "\n"
                    . "\n"
                    . "// Generating insert in table cstm"
                    . "\n"
                    . '$data_table_cstm = ($data instanceof ' . $this->getCamelCase($this->actual_table) . 'Cstm) ? (array) $data : (array) $this->setObjectDataCstm($data);'
                    . "\n"
                    . '$data_table_cstm[\'id_c\'] = $this->id;'
                    . "\n"
                    . '$insert = new Insert(\'' . $this->actual_table . '_cstm' . '\');'
                    . "\n"
                    . '$insert->values($data_table_cstm);'
                    . "\n"
                    . '$result_cstm = $sql->prepareStatementForSqlObject($insert)->execute();'
                    . "\n"
                    . 'if ($result_cstm->getAffectedRows() === 0) {'
                    . "\n"
                    . "\t" . 'return false;'
                    . "\n"
                    . '}';
        }

        $body .= "\n"
                . "\n"
                . 'return $this->id;';





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
                . '$data_table = ($data instanceof ' . $this->getCamelCase($this->actual_table) . ') ? (array) $data : (array) $this->setObjectData($data);'
                . "\n"
                . 'unset($data_table[\'id\']);'
                . "\n"
                . '$data_table = $this->unsetNullsInUpdate($data_table);'
                . "\n"
                . '$sql = new Sql($this->adapter);'
                . "\n"
                . '$update = new Update(\'' . $this->actual_table . '\');'
                . "\n"
                . '$update->set($data_table);'
                . "\n"
                . '$update->where([\'id\' => $id]);'
                . "\n"
                . '$result = $sql->prepareStatementForSqlObject($update)->execute();'
                . "\n"
        ;

        if ($this->table_cstm_exists) {
            $body .= "\n"
                    . '$data_table_cstm = ($data instanceof ' . $this->getCamelCase($this->actual_table) . 'Cstm) ? (array) $data : (array) $this->setObjectDataCstm($data);'
                    . "\n"
                    . '$data_table_cstm[\'id_c\']= $id;'
                    . "\n"
                    . '$data_table_cstm = $this->unsetNullsInUpdate($data_table_cstm);'
                    . "\n"
                    . '$sql = new Sql($this->adapter);'
                    . "\n"
                    . '$update = new Update(\'' . $this->actual_table . '_cstm\');'
                    . "\n"
                    . '$update->set($data_table_cstm);'
                    . "\n"
                    . '$update->where([\'id_c\' => $id]);'
                    . "\n"
                    . '$result_cstm = $sql->prepareStatementForSqlObject($update)->execute();'
                    . "\n"
                    . 'return $result->getAffectedRows();'

            ;
        }



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
                . 'if ( !$softDelete){'
                . "\n"
                . "\t" . '$delete = new Delete(\'' . $this->actual_table . '\');'
                . "\n"
                . "\t" . '$delete->where([\'id\' => $id]);'
                . "\n"
                . "\t" . '$result = $sql->prepareStatementForSqlObject($delete)->execute();'
                . "\n"
                . "\n";

        if ($this->table_cstm_exists) {
            $body .= "\t" . '$delete_cstm = new Delete(\'' . $this->actual_table . '_cstm\');'
                    . "\n"
                    . "\t" . '$delete_cstm->where([\'id_c\' => $id]);'
                    . "\n"
                    . "\t" . '$result_cstm = $sql->prepareStatementForSqlObject($delete_cstm)->execute();'
                    . "\n"
                    . "\t" . 'return $result->getAffectedRows();'
                    . "\n";
        }
        $body .= '} else { '
                . "\n"
                . "\n"
                . "\t" . '$delete_soft = new Update(\'' . $this->actual_table . '\');'
                . "\n"
                . "\t" . '$delete_soft->set([\'deleted\' => 1]);'
                . "\n"
                . "\t" . '$delete_soft->where([\'id\' => $id]);'
                . "\n"
                . "\t" . '$result = $sql->prepareStatementForSqlObject($delete_soft)->execute();'
                . "\n"
                . "\t" . 'return $result->getAffectedRows();'
                . "\n"
                . '}'
                . "\n"
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
                . "\t" . '$result = (array) $this->setObjectData($result->current());'
                . "\n"
                . '}else{'
                . "\n"
                . "\t" . 'return false;'
                . "\n"
                . '}'
        ;

        if ($this->table_cstm_exists) {
            $body .= "\n"
                    . '$select_cstm = new Select(\'' . $this->actual_table . '_cstm\');'
                    . "\n"
                    . '$select_cstm->where([\'id_c\' => $id]);'
                    . "\n"
                    . '$result_cstm = $sql->prepareStatementForSqlObject($select_cstm)->execute();'
                    . "\n"
                    . 'if ( $result_cstm->count() > 0){'
                    . "\n"
                    . "\t" . '$result_cstm = (array) $this->setObjectDataCstm($result_cstm->current());'
                    . "\n"
                    . '}else{'
                    . "\n"
                    . "\t" . 'return false;'
                    . "\n"
                    . '}'
            ;
        }

        // seting date time 

        if ($this->table_cstm_exists) {
            $body .= "\n"
                    . 'return array_merge($result, $result_cstm);';
        } else {
            $body .= "\n"
                    . 'return $result;';
        }



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
                . "\t" . '$resultSet = new HydratingResultSet();'
                . "\n"
                . "\t" . '$resultSet->setHydrator(new ObjectProperty());'
                . "\n"
                . "\t" . '$resultSet->setObjectPrototype(new ' . $this->getCamelCase($this->actual_table) . '());'
                . "\n"
                . "\t" . '$resultSet->initialize($result);'
                . "\n"
                . "\t" . 'return $resultSet;'
                . "\n"
                . '} else {'
                . "\n"
                . "\t" . 'return false;'
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
                . '$data = (array) $data;'
                . "\n"
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
        $method->setVisibility(MethodGenerator::FLAG_PRIVATE);
        $method->setBody($body);
        return $method;
    }

    private function generateSetObjectDataCstmMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$data = (array) $data;'
                . "\n"
                . ''
                . '$' . $this->actual_table . '_cstm = new ' . $this->getCamelCase($this->actual_table) . 'Cstm();'
                . "\n" . '$' . $this->actual_table . '_cstm->exchangeArray($data);'
                . "\n" . 'return $' . $this->actual_table . '_cstm;';

        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('setObjectDataCstm');
        $method->setParameter('data');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Return instance of ' . $this->getCamelCase($this->actual_table) . 'Cstm',
                    'longDescription' => null,
        ]));
        $method->setVisibility(MethodGenerator::FLAG_PRIVATE);
        $method->setBody($body);
        return $method;
    }

    private function generateGenerateIdMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$this->id = create_guid();';

        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('generateId');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Generate an id for' . $this->getCamelCase($this->actual_table),
                    'longDescription' => null,
        ]));
        $method->setVisibility(MethodGenerator::FLAG_PRIVATE);
        $method->setBody($body);
        return $method;
    }

    private function generateUnsetNullsInUpdate() {
        // Agregando body de metodo store
        $body = "\n"
                . 'foreach ($data as $key => $value) {'
                . "\n"
                . "\t" . 'if ($value === null) {'
                . "\n"
                . "\t" . "\t" . ' unset($data[$key]);'
                . "\n"
                . "\t" . '}'
                . "\n"
                . '}'
                . "\n"
                . '  return $data;'
        ;




        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('unsetNullsInUpdate');
        $parameter = new Zend\Code\Generator\ParameterGenerator();
        $parameter->setName('data');
        $parameter->setPassedByReference(true);

        $method->setParameter($parameter);
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Generate an id for' . $this->getCamelCase($this->actual_table),
                    'longDescription' => null,
        ]));
        $method->setVisibility(MethodGenerator::FLAG_PRIVATE);
        $method->setBody($body);
        return $method;
    }

    private function generateSetDefaultInsertValues($columns) {
        // Agregando body de metodo store
        $body = "\n"
                . '$data = $this->setObjectData($data);'
                . "\n"
                . 'global $current_user;'
                . "\n"
                . 'if ( $current_user instanceof User ){'
                . "\n"
                . "\t" . '$id = $current_user->id();'
                . "\n"
                . '}'

        ;

        if (count($columns) > 0) {
            foreach ($columns as $column) {
                $data_default = $this->getDefaultInsertColumn($column);
                if ($data_default !== 'null') {
                    $body .= "\n" . $this->getDefaultInsertColumn($column) . ';';
                }
            }
        }

        $body .= "\n"
                . 'return (array) $data;';


        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('generateSetDefaultInsertValues');
        $method->setParameter('data');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Generate default Values for insert ' . $this->getCamelCase($this->actual_table),
                    'longDescription' => null,
        ]));
        $method->setVisibility(MethodGenerator::FLAG_PRIVATE);
        $method->setBody($body);
        return $method;
    }

    private function getDefaultInsertColumn($column) {

        $default = 'null';
        switch ($column->getName()) {
            case 'date_entered':
            case 'date_modified':
            case 'date_modified':
                $default = '$data->' . $column->getName() . ' = $this->now';
                break;
            case 'deleted':
                $default = '$data->' . $column->getName() . ' = 0';
            case 'modified_user_id':
            case 'assigned_user_id':
                $default = '$data->' . $column->getName() . ' =  ($id !== null) ? $id : $data[\'' . $column->getName() . '\'];';
            default:

                break;
        }
        return $default;
    }

    private function checkIfDirExist($dir) {


        if (@!dir($dir)) {
            mkdir($dir);
        }
    }

    private function generateFile($fileName, $class) {

        $file = new FileGenerator();
        $file->setClass($class);
        @$model = $file->generate();
        $file_saved = $this->dir . 'base/' . $this->getCamelCase($fileName) . 'MapperBase.php';
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

    private function getTablesToGenerate() {
        require __DIR__ . './tablesToGenerate.php';
        $this->tablesAllowed = $tables;
    }

}

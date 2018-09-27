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

    // Adaptador de base de datos
    protected $adapter;
    // Metada 
    protected $metadata;
    // Directorio creado
    protected $dir;
    // Archivos creados
    protected $filesCreated = [];
    // Tabla actual
    protected $actual_table;
    // Tablas relacionadas de la tabla actual
    protected $actual_relationships = [];
    // Valor si existe auxiliar en tabla actual
    protected $table_cstm_exists;
    // Valor si existe auxiliar en tabla actual
    protected $table_audit_exists;
    // Valor si existe relacion en la tabla actual
    protected $table_relationship_exists;
    // Todas las tablas
    protected $tables;
    // Todas las tablas auxiliares
    protected $tables_cstm = [];
    // Todas las tablas de relacion
    protected $tables_relationship = [];
    // Tablas permitidas para generar
    protected $tablesAllowed;
    // Restringe el acceso ( solo una tabla ) 
    protected $restric_table = null;
    // Output console value
    protected $output = null;
    // Sobre escribe mappers..
    protected $overwrite = false;
    // Metodos de relacion
    protected $relationship_methods = [];

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

    public function generate() {

        $this->tables = $this->metadata->getTableNames();

        $this->filterTables();

        foreach ($this->tables as $tableName) {
            // seteo la variable actual como global en la clase.
            $this->actual_table = $tableName;

            // Salto las tablas cstm para la generacion de mappers ( se generan por tabla ) 
            if (substr($tableName, -5) === '_cstm') {
                continue;
            }
            //salto las tablas de relacion ( se generan por tabla ) 
            if (substr($tableName, -4) === '_1_c') {
                continue;
            }

            // Verifico si la tabla actual tiene tablas auxiliares
            $this->table_cstm_exists = false;
            if (in_array($tableName . '_cstm', $this->tables)) {
                $this->table_cstm_exists = true;
            }
            // Verifico si la tabla actual tiene tablas auxiliares
            $this->table_audit_exists = false;
            if (in_array($tableName . '_audit', $this->tables)) {
                $this->table_audit_exists = true;
            }

            // Verifico si viene una sola tabla que es la que se procesará
            if ($this->restric_table !== null) {
                if ($this->restric_table !== $tableName) {
                    continue;
                }
            }



            $class = new ClassGenerator();
            $class->addProperty('adapter', null, PropertyGenerator::FLAG_PROTECTED);
            $class->addProperty('id', null, PropertyGenerator::FLAG_PROTECTED);
            $class->addProperty('now', null, PropertyGenerator::FLAG_PROTECTED);
            $class->addProperty('logger', null, PropertyGenerator::FLAG_PROTECTED);
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


            //constructor
            $class->addMethodFromGenerator($this->generateConstructorMethod());

            // querys
            $class->addMethodFromGenerator($this->generateStoreMethod());
            $class->addMethodFromGenerator($this->generateUpdateMethod());
            $class->addMethodFromGenerator($this->generateDeleteMethod());
            $class->addMethodFromGenerator($this->generateGetMethod());
            $class->addMethodFromGenerator($this->generateFindOneByMethod());
            $class->addMethodFromGenerator($this->generateFindManyByMethod());
            $class->addMethodFromGenerator($this->generateGetAllMethod());
            $class->addMethodFromGenerator($this->generateInitLog());
            $class->addMethodFromGenerator($this->generateDebugQueryMethod());
            $class->addMethodFromGenerator($this->generateHtmlBeutyQuery());
            // Verifico si tengo tablas de relacion
            $this->checkIfExistsRelationship($tableName);
            if ($this->table_relationship_exists) {
                $this->generateRelationShipMethods($tableName);
                foreach ($this->relationship_methods as $method) {
                    $class->addMethodFromGenerator($method);
                }
            }


            // privados
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
        $parameter = new \Zend\Code\Generator\ParameterGenerator();
        $parameter->setName('adapter');
        $parameter->setDefaultValue(null);
        $constructorMethod->setParameter($parameter);
        $constructorMethod->setBody($bodyConstructor);

        $class = new ClassGenerator();
        $class->setName($this->getCamelCase($this->actual_table) . 'Mapper');
        $class->addMethodFromGenerator($constructorMethod);
        $class->setExtendedClass($this->getCamelCase($this->actual_table) . 'MapperBase');



        $tableTag = new Zend\Code\Generator\DocBlock\Tag\GenericTag();
        $tableTag->setName('table');
        $tableTag->setContent($this->actual_table);

        $authorTag = new Zend\Code\Generator\DocBlock\Tag\GenericTag();
        $authorTag->setName('author');
        $authorTag->setContent('Cristian Nores <cristian.nores@gmail.com');

        $docBlock = new DocBlockGenerator();
        $docBlock->setLongDescription("Mapper generated by zend-code-generator-zf3\nhttps://github.com/cristiannores/zf3-code-generator-suite-crm");
        $docBlock->setTag($tableTag);
        $docBlock->setTag($authorTag);


        $file = new FileGenerator();
        $file->setClass($class);
        $file->setDocBlock($docBlock);
        @$model = $file->generate();
        $file_saved = $this->dir . '' . $this->getCamelCase($this->actual_table) . 'Mapper.php';

        if (file_exists($file_saved)) {

            if ($this->overwrite) {
                file_put_contents($file_saved, $model);
                return $file_saved;
            }
        } else {
            file_put_contents($file_saved, $model);
            return $file_saved;
        }


        return false;
    }

    private function generateConstructorMethod() {
        //Generating parameter
        $parameterAdapter = new \Zend\Code\Generator\ParameterGenerator();
        $parameterAdapter->setName('adapter');
        $parameterAdapter->setDefaultValue(null);
        // Generating body

        $body = <<< CONSTRUCTOR
if ( \$adapter ){
    \$this->adapter = \$adapter;
} else {
    \$this->adapter = (new Database())->getAdapter();
}
                
global \$sugar_config;
\$this->config  = \$sugar_config;
                
 if (\$this->config['query_log']) {

    \$this->logger = new CustomLogger('sql-' . date('Y-m-d') . '.log');
    \$this->init_log();
}
        
\$date_now_utc = (new \DateTime( 'now',  new \DateTimeZone( 'UTC' ) ));
\$this->now = \$date_now_utc->format('Y-m-d H:i:s');
CONSTRUCTOR;


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
                . '$data_table = ($data instanceof ' . $this->getCamelCase($this->actual_table) . 'Model ) ? (array) $data : (array) $this->setObjectData($data);'
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
                . '$this->debug_query($insert);'
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
                    . '$data_table_cstm = ($data instanceof ' . $this->getCamelCase($this->actual_table) . 'CstmModel) ? (array) $data : (array) $this->setObjectDataCstm($data);'
                    . "\n"
                    . '$data_table_cstm[\'id_c\'] = $this->id;'
                    . "\n"
                    . '$insert = new Insert(\'' . $this->actual_table . '_cstm' . '\');'
                    . "\n"
                    . '$insert->values($data_table_cstm);'
                    . "\n"
                    . '$this->debug_query($insert);'
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

    private function generateFindOneByMethod() {


        $body = <<< EOD

\$values = (array) \$this->setObjectData(\$data);
\$values = \$this->unsetNullsInUpdate(\$values); 
    
if (count(\$values) < 1) {
    return false;
}

\$sql = new Sql(\$this->adapter);

\$select = new Select('{$this->actual_table}');
\$select->where(\$values);
\$select->limit(1);

\$this->debug_query(\$select);
                    
\$result = \$sql->prepareStatementForSqlObject(\$select)->execute();

if (\$result instanceof ResultInterface && \$result->isQueryResult()) {

    if (\$result->count() > 0){
        return (array) \$result->current();
    } else {
        return false;
    }
    
} else {
    return false;
}
EOD;
        $body_cstm = <<< EOD

// getting data from both tables
\$data_table = (array) \$this->setObjectData(\$data);
\$data_cstm = (array) \$this->setObjectDataCstm(\$data);

// generating the values array merging the two objects
\$values = array_merge(\$data_table, \$data_cstm);
\$values = \$this->unsetNullsInUpdate(\$values);                
if (count(\$values) < 1) {
    return false;
}

\$sql = new Sql(\$this->adapter);

\$select = new Select('{$this->actual_table}');
\$select->join('{$this->actual_table}_cstm', '{$this->actual_table}_cstm.id_c = {$this->actual_table}.id', [], \$select::JOIN_INNER);
\$select->where(\$values);
\$select->limit(1);

\$this->debug_query(\$select);

\$result = \$sql->prepareStatementForSqlObject(\$select)->execute();

if (\$result instanceof ResultInterface && \$result->isQueryResult()) {

    if (\$result->count() > 0){
        return (array) \$result->current();
    } else {
        return false;
    }
    
} else {
    return false;
}
EOD;

        $docBlock = new DocBlockGenerator();
        $docBlock->setShortDescription('Metodo que busca ' . $this->actual_table . ' por parametros de la tabla');
        $method = new MethodGenerator();
        $method->setVisibility($method::VISIBILITY_PUBLIC);
        $method->setName('findOneBy');
        $method->setDocBlock($docBlock);
        $method->setParameter('data');
        if ($this->table_cstm_exists) {
            $method->setBody($body_cstm);
        } else {
            $method->setBody($body);
        }



        return $method;
    }

    private function generateFindManyByMethod() {


        $body_cstm = <<< EOD

// getting data from both tables
\$data_table = (array) \$this->setObjectData(\$data);
\$data_cstm = (array) \$this->setObjectDataCstm(\$data);

// generating the values array merging the two objects
\$values = array_merge(\$data_table, \$data_cstm);
\$values = \$this->unsetNullsInUpdate(\$values);                
if (count(\$values) < 1) {
    return false;
}

\$sql = new Sql(\$this->adapter);

\$select = new Select('{$this->actual_table}');
\$select->join('{$this->actual_table}_cstm', '{$this->actual_table}_cstm.id_c = {$this->actual_table}.id', [], \$select::JOIN_INNER);
\$select->where(\$values);

// setting limit if exists
if ( \$limit ){

    \$select->limit(\$limit);
}

// seting offset if exists        
if ( \$offset ){

    \$select->offset(\$offset);
}

// seting order if exists        
if ( \$order ){

    \$select->order(\$order);
}

\$this->debug_query(\$select);
\$result = \$sql->prepareStatementForSqlObject(\$select)->execute();

if (\$result instanceof ResultInterface && \$result->isQueryResult()) {

    if (\$result->count() > 0){
        return \$result;
    } else {
        return false;
    }
    
} else {
    return false;
}
EOD;
        $body = <<< EOD

// getting data from both tables
\$values = (array) \$this->setObjectData(\$data);
\$values = \$this->unsetNullsInUpdate(\$values);                
if (count(\$values) < 1) {
    return false;
}

\$sql = new Sql(\$this->adapter);

\$select = new Select('{$this->actual_table}');
\$select->where(\$values);

// setting limit if exists
if ( \$limit ){

    \$select->limit(\$limit);
}

// seting offset if exists        
if ( \$offset ){

    \$select->offset(\$offset);
}

// seting order if exists        
if ( \$order ){

    \$select->order(\$order);
}


\$this->debug_query(\$select);
\$result = \$sql->prepareStatementForSqlObject(\$select)->execute();

if (\$result instanceof ResultInterface && \$result->isQueryResult()) {

    if (\$result->count() > 0){
        return \$result;
    } else {
        return false;
    }
    
} else {
    return false;
}
EOD;



        $docBlock = new DocBlockGenerator();
        $docBlock->setShortDescription('Metodo que busca muchos ' . $this->actual_table . ' por parametros de la tabla');
        $method = new MethodGenerator();
        $method->setVisibility($method::VISIBILITY_PUBLIC);
        $method->setName('findManyBy');
        $method->setDocBlock($docBlock);
        $method->setParameter('data');
        // agrego el parametro limit
        $parameter = new \Zend\Code\Generator\ParameterGenerator();
        $parameter->setDefaultValue(null);
        $parameter->setName('limit');
        $method->setParameter($parameter);
        // agregeo el parametro offset
        $parameter = new \Zend\Code\Generator\ParameterGenerator();
        $parameter->setDefaultValue(null);
        $parameter->setName('offset');
        $method->setParameter($parameter);
        // agregeo el parametro offset
        $parameter = new \Zend\Code\Generator\ParameterGenerator();
        $parameter->setDefaultValue(null);
        $parameter->setName('order');
        $method->setParameter($parameter);
        if ($this->table_cstm_exists) {
            $method->setBody($body_cstm);
        } else {
            $method->setBody($body);
        }



        return $method;
    }

    private function generateUpdateMethod() {
        // Agregando body de metodo store
        $body = "\n"
                . '$find = $this->get($id);'
                . "\n"
                . "\n"
                . 'if(!$find){'
                . "\n"
                . "\t" . 'return false;'
                . "\n"
                . '}'
                . "\n"
                . "\n"
                . '$data_table = ($data instanceof ' . $this->getCamelCase($this->actual_table) . 'Model ) ? (array) $data : (array) $this->setObjectData($data);'
                . "\n"
                . 'unset($data_table[\'id\']);'
                . "\n"
                . '$data_table = $this->unsetNullsInUpdate($data_table);'
                . "\n"
                . "\n"
                . '$sql = new Sql($this->adapter);'
                . "\n"
                . '$update = new Update(\'' . $this->actual_table . '\');'
                . "\n"
                . '$update->set($data_table);'
                . "\n"
                . '$update->where([\'id\' => $id]);'
                . "\n"
                . '$this->debug_query($update);'
                . "\n"
                . '$result = $sql->prepareStatementForSqlObject($update)->execute();'
                . "\n"
        ;

        if ($this->table_cstm_exists) {
            $body .= "\n"
                    . '$data_table_cstm = ($data instanceof ' . $this->getCamelCase($this->actual_table) . 'CstmModel ) ? (array) $data : (array) $this->setObjectDataCstm($data);'
                    . "\n"
                    . '$data_table_cstm[\'id_c\']= $id;'
                    . "\n"
                    . '$data_table_cstm = $this->unsetNullsInUpdate($data_table_cstm);'
                    . "\n"
                    . "\n"
                    . '$sql = new Sql($this->adapter);'
                    . "\n"
                    . '$update = new Update(\'' . $this->actual_table . '_cstm\');'
                    . "\n"
                    . '$update->set($data_table_cstm);'
                    . "\n"
                    . '$update->where([\'id_c\' => $id]);'
                    . "\n"
                    . '$this->debug_query($update);'
                    . "\n"
                    . '$result_cstm = $sql->prepareStatementForSqlObject($update)->execute();'
                    . "\n" . "\n";


            ;
        }
        $camelCaseAudit = $this->getCamelCase($this->actual_table) . "Audit";

        if ($this->table_cstm_exists) {

            if ($this->table_audit_exists) {
                $body .= <<<AA
if (( \$result->getAffectedRows() +  \$result_cstm->getAffectedRows() ) > 0 ){
    \$audit = new $camelCaseAudit(\$find, array_merge(\$data_table, \$data_table_cstm), \$id, true, \$this->adapter);
    \$audit->generate();            
}
return \$result->getAffectedRows() +  \$result_cstm->getAffectedRows();                   
AA;
            } else {
                $body .= <<<AA
 
return \$result->getAffectedRows() +  \$result_cstm->getAffectedRows();                   
AA;
            }
        } else {

            if ($this->table_audit_exists) {
                $body .= <<<AA
if ( \$result->getAffectedRows()  > 0 ){
    \$audit = new $camelCaseAudit(\$find, array_merge(\$data_table), \$id, true, \$this->adapter) ;
    \$audit->generate();            
}
return \$result->getAffectedRows();                                       
AA;
            } else {
                $body .= <<<AA
 
return \$result->getAffectedRows();                                       
AA;
            }
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
                . "\n"
                . "\t" . '$this->debug_query($delete);'
                . "\n"
                . "\n"
                . "\t" . '$result = $sql->prepareStatementForSqlObject($delete)->execute();'
                . "\n"
                . "\n";

        if ($this->table_cstm_exists) {
            $body .= "\t" . '$delete_cstm = new Delete(\'' . $this->actual_table . '_cstm\');'
                    . "\n"
                    . "\t" . '$delete_cstm->where([\'id_c\' => $id]);'
                    . "\n"
                     . "\t" . '$this->debug_query($delete_cstm);'
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
                . '$this->debug_query($delete_soft);'
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
                . '$this->debug_query($select);'
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
                    . '$this->debug_query($select_cstm);'
                    . "\n"
                    . '$result_cstm = $sql->prepareStatementForSqlObject($select_cstm)->execute();'
                    . "\n"
                    . 'if ( $result_cstm->count() > 0){'
                    . "\n"
                    . "\t" . '$result_cstm = (array) $this->setObjectDataCstm($result_cstm->current());'
                    . "\n"
                    . '}else{'
                    . "\n"
                    . "\t" . '$result_cstm = [];'
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
                . '$this->debug_query($select);'
                . "\n"
                . '$result = $sql->prepareStatementForSqlObject($select)->execute();'
                . "\n"
                . 'if ($result instanceof ResultInterface && $result->isQueryResult()) {'
                . "\n"
                . "\t" . '$resultSet = new HydratingResultSet();'
                . "\n"
                . "\t" . '$resultSet->setHydrator(new ObjectProperty());'
                . "\n"
                . "\t" . '$resultSet->setObjectPrototype(new ' . $this->getCamelCase($this->actual_table) . 'Model());'
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
                . '$' . $this->actual_table . ' = new ' . $this->getCamelCase($this->actual_table) . 'Model();'
                . "\n" . '$' . $this->actual_table . '->exchangeArray($data);'
                . "\n" . 'return $' . $this->actual_table . ';';

        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('setObjectData');
        $method->setParameter('data');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Return instance of ' . $this->getCamelCase($this->actual_table) . 'Model',
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
                . '$' . $this->actual_table . '_cstm = new ' . $this->getCamelCase($this->actual_table) . 'CstmModel();'
                . "\n" . '$' . $this->actual_table . '_cstm->exchangeArray($data);'
                . "\n" . 'return $' . $this->actual_table . '_cstm;';

        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('setObjectDataCstm');
        $method->setParameter('data');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Return instance of ' . $this->getCamelCase($this->actual_table) . 'CstmModel',
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
                . "\t" . 'if (is_null($value)) {'
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
                . "\t" . '$id = $current_user->id;'
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

        $parameter = new Zend\Code\Generator\ParameterGenerator();
        $parameter->setName('update');
        $parameter->setDefaultValue(false);
        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('generateSetDefaultInsertValues');
        $method->setParameter('data');
        $method->setParameter($parameter);
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Generate default Values for insert ' . $this->getCamelCase($this->actual_table),
                    'longDescription' => null,
        ]));
        $method->setVisibility(MethodGenerator::FLAG_PRIVATE);
        $method->setBody($body);
        return $method;
    }

    private function generateRelationShipMethods($tableName) {
        $this->output->writeln('La tabla tiene relaciones generando metodos de relación');
        foreach ($this->actual_relationships as $rel) {

            // Docs
            $docBlock = new DocBlockGenerator();
            $docBlock->setShortDescription('Agregar un ' . $rel['relation_with']);


            // Generando metodo de relacion
            $method = new MethodGenerator();
            $method->setDocBlock($docBlock);
            $method->setName('addRelationship' . $this->getCamelCase($rel['relation_with']));

            // Obtengo las columnas 

            $columnas = $this->metadata->getColumns($rel['relation_table']);

            // construyo el body de la tabla 

            $body = "\n"
                    . "\n"
                    . 'if( $checkExists ){'
                    . "\n"
                    . "\t" . 'if(!$this->get( $' . $tableName . '_id' . ' )) {'
                    . "\n"
                    . "\t" . "\t" . 'return false;'
                    . "\n"
                    . "\t" . '}'
                    . "\n"
                    . '}'
                    . "\n"
                    . "\n"
                    . '$this->generateId();'
                    . "\n" . "\n"
                    . '// Generando data insert '
                    . "\n"
                    . '$data = [];'
                    . "\n"
                    . "\n"
            ;

            // Obtengo los parametros de la tabla de relacion
            foreach ($columnas as $col) {

                if ($col->getName() == 'date_modified') {
                    $body .= '$data[\'id\'] = $this->id;';
                    $body .= "\n";
                }

                if ($col->getName() == 'date_modified') {
                    $body .= '$data[\'date_modified\'] = $this->now;';
                    $body .= "\n";
                }

                if ($col->getName() == 'deleted') {
                    $body .= '$data[\'deleted\'] = 0;';
                    $body .= "\n";
                }

                // Obtengo la id a generar
                if (strpos($col->getName(), "1" . $rel['relation_with']) !== false) {

                    $relation_ship_name = $col->getName();
                    $relation_ship_id = $rel['relation_with'] . '_id';
                    $method->setParameter($relation_ship_id);

                    $body .= '$data[\'' . $relation_ship_name . '\'] = $' . $relation_ship_id . ";";
                    $body .= "\n";
                }
                // Obtengo la id actual 
                if (strpos($col->getName(), "1" . $tableName) !== false) {

                    $actual_table_name = $col->getName();
                    $actual_table_id = $tableName . '_id';
                    $method->setParameter($actual_table_id);


                    $body .= '$data[\'' . $actual_table_name . '\'] = $' . $actual_table_id . ";";
                    $body .= "\n";
                }
            }

            // generando parametro de checkear si existen los ids
            $parameter = new \Zend\Code\Generator\ParameterGenerator();
            $parameter->setName('checkExists');
            $parameter->setDefaultValue(false);


            $method->setParameter($parameter);

            $body .= "\n"
                    . "\n"
                    . '$sql = new Sql($this->adapter);'
                    . "\n"
                    . '$insert = new Insert(\'' . $rel['relation_table'] . '\');'
                    . "\n"
                    . '$insert->values($data);'
                    . "\n"
                    . "\$this->debug_query(\$insert);"
                    . "\n"
                    . '$result = $sql->prepareStatementForSqlObject($insert)->execute();'
                    . "\n"
                    . 'if ($result->getAffectedRows() > 0) {'
                    . "\n"
                    . "\t" . 'return $this->id;'
                    . "\n"
                    . '}'
                    . "\n"
                    . 'return false;';




            $method->setBody($body);


            $this->relationship_methods[] = $method;
        }
    }

    private function generateInitLog() {

        $body = <<<BODY
\$a = debug_backtrace();
\$msg = "CLASS :: " . \$a[1]['class'] . " >> FUNCTION :: " . \$a[1]['function'] . " ";
\$this->logger->cochalog(\$this->logger::DEBUG, \$msg);

BODY;

        $method = new MethodGenerator();
        $method->setName('init_log');
        $method->setBody($body);
        $method->setVisibility($method::VISIBILITY_PUBLIC);
        return $method;
    }

    private function generateDebugQueryMethod() {
        $body = <<<BODY
 if (\$this->config['query_log']) {
    if (!\$isRaw) {
        \$query = \$object->getSqlString(\$this->adapter->getPlatform());
    }

    if (!\$this->config['production_env']) {
        \$this->generate_html_beuty_query(\$query);
    }


    \$this->logger->cochalog(\$query);
}

BODY;

        $param = new Zend\Code\Generator\ParameterGenerator();
        $param->setName('isRaw');
        $param->setDefaultValue(null);

        $method = new MethodGenerator();
        $method->setName('debug_query');
        $method->setBody($body);
        $method->setParameter('object');
        $method->setParameter($param);
        $method->setVisibility($method::VISIBILITY_PUBLIC);
        return $method;
    }

    private function generateHtmlBeutyQuery() {
        $body = <<<BODY
\$file_name_arr = __DIR__ . "/../../../querys.json";
\$a = debug_backtrace();

\$id = serialize(\$a[1]['class'] . \$a[2]['function']);
\$element[\$id] = [];




\$query_arrays = json_decode(file_get_contents(\$file_name_arr), true);
if (\$query_arrays == null || !is_array(\$query_arrays)) {
    \$query_arrays = [];
}
\$now =  (new \DateTime('now',  new \DateTimeZone( 'America/Santiago' )));

if (!is_array(\$query_arrays[\$id])) {
    \$query_arrays[\$id] = [];
}

\$query_arrays[\$id][] = [
    'class' => \$a[1]['class'],
    'query' => \$query,
    'method' =>\$a[2]['function'],
    'date' => \$now->format('Y-m-d H:i:s')
];




file_put_contents(\$file_name_arr, json_encode(\$query_arrays));
BODY;
        $method = new MethodGenerator();
        $method->setName('generate_html_beuty_query');
        $method->setBody($body);
        $method->setParameter('query');

        $method->setVisibility($method::VISIBILITY_PUBLIC);
        return $method;
    }

    private function getDefaultInsertColumn($column) {

        $default = 'null';
        switch ($column->getName()) {
            case 'date_created':
            case 'date_entered':
            case 'date_modified':
            case 'date_modified':
                $default = '$data->' . $column->getName() . ' = $this->now';
                break;
            case 'deleted':
                $default = '$data->' . $column->getName() . ' = 0';
                break;
            case 'modified_user_id':
            case 'assigned_user_id':
                $default = '$data->' . $column->getName() . ' =  ($id !== null) ? $id : $data->' . $column->getName() . '; ';
            break;  
        
            case 'created_by': 
                $default = 'if(!$update){';
                
                $default .="\t". '$data->' . $column->getName() . ' =  ($id !== null) ? $id : $data->' . $column->getName() . '; ';
                $default .= "}";
            break;
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

    private function generateFile($fileName, ClassGenerator $class) {

        $tableTag = new Zend\Code\Generator\DocBlock\Tag\GenericTag();
        $tableTag->setName('table');
        $tableTag->setContent($this->actual_table);

        $authorTag = new Zend\Code\Generator\DocBlock\Tag\GenericTag();
        $authorTag->setName('author');
        $authorTag->setContent('Cristian Nores <cristian.nores@gmail.com');

        $docBlock = new DocBlockGenerator();
        $docBlock->setLongDescription("Mapper generated by zend-code-generator-zf3\nhttps://github.com/cristiannores/zf3-code-generator-suite-crm");
        $docBlock->setTag($tableTag);
        $docBlock->setTag($authorTag);

        $file = new FileGenerator();
        $file->setDocBlock($docBlock);
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

    private function filterTables() {
        foreach ($this->tables as $table) {
            if (strpos($table, 'cstm') !== false) {
                $this->tables_cstm[] = $table;
            }
            if (strpos($table, '_1_c') !== false) {
                $this->tables_relationship[] = $table;
            }
        }
    }

    private function checkIfExistsRelationship($tableName) {
        $this->table_relationship_exists = false;
        $relationships = [];
        foreach ($this->tables_relationship as $table) {
            $find = str_replace('_1_c', '', $table);
            // Verifico si existe la tabla si es asi extraigo la otra tabla y la almaceno
            if (strpos($find, $tableName) !== false) {
                $relationships = explode('_', $find);
                // remuevo la tabla propia para dejar solo la relacion
                foreach ($relationships as $key => $rel) {
                    if ($rel === $tableName) {
                        unset($relationships[$key]);
                    }
                }
                $this->table_relationship_exists = true;
                // Obtengo las relaciones..
                $columns = $this->metadata->getColumns($table);

                foreach ($columns as $col) {
                    if (strpos($col->getName(), $tableName . '_ida') !== false) {
                        $this->actual_relationships[] = ['relation_with' => $this->getNameTableList($table, $tableName), 'relation_table' => $table];
                    }
                }
            }
        }
    }

    private function getNameTableList($str, $actual) {


        $find = str_replace($actual, '', $str);

        foreach ($this->tables as $table) {

            if (strpos($find, $table) !== false) {

                return $table;
            }
        }
    }

}

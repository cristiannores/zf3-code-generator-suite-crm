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

class AuditedGenerator {

    protected $adapter;
    protected $metadata;
    protected $dir;
    protected $tables;
    protected $filesCreated = [];
    protected $tablesAllowed;
    protected $restric_table = null;
    protected $output = null;
    protected $actual_table;

    public function __construct() {

        $this->output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $this->dir = $GLOBALS['suite_crm_path'] . '/custom/mappers/audit/';
        $db = new Database();
        $this->adapter = $db->getAdapter();
        $this->metadata = Factory::createSourceFromAdapter($this->adapter);
        $this->generateDirectory();
    }

    private function generateDirectory() {
        if (!file_exists($this->dir)) {
            mkdir($this->dir, 0777, true);
        }
    }

    public function generate() {
        $this->tables = $this->metadata->getTableNames();
        foreach ($this->tables as $tableName) {

            $this->actual_table = $tableName;
            // Verifico si viene una sola tabla que es la que se procesará
            if ($this->restric_table !== null) {
                if ($this->restric_table . '_audit' !== $tableName) {
                    continue;
                } else {
                    $this->output->writeln('sale');
                }
            }


            if (substr($tableName, -6) === '_audit') {

                $this->output->writeln('Archivo  encontrado : ');
                $class = new ClassGenerator();
                $class->addProperty('adapter', null, PropertyGenerator::FLAG_PROTECTED);
                $class->addProperty('id', null, PropertyGenerator::FLAG_PROTECTED);
                $class->addProperty('now', null, PropertyGenerator::FLAG_PROTECTED);
                $class->addProperty('auditFields', null, PropertyGenerator::FLAG_PUBLIC);
                $class->addProperty('table', null, PropertyGenerator::FLAG_PROTECTED);
                $class->addProperty('all', null, PropertyGenerator::FLAG_PROTECTED);
                $class->addProperty('table_id', null, PropertyGenerator::FLAG_PROTECTED);
                $class->addProperty('beforeData', null, PropertyGenerator::FLAG_PROTECTED);
                $class->addProperty('afterData', null, PropertyGenerator::FLAG_PROTECTED);
                $class->setName($this->getCamelCase($tableName) . '');
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
                $class->addMethodFromGenerator($this->genereateGenerateMethod());
                $class->addMethodFromGenerator($this->generateAuditMethod());
                $class->addMethodFromGenerator($this->generateMethodCheckAuditFields());
                $class->addMethodFromGenerator($this->generateGenerateIdMethod());
                $this->output->writeln('Archivo  no generado : ');
                $file = $this->generateFile($tableName, $class);
                $this->output->writeln('Archivo generado : ' . $file);
            } else {
                continue;
            }
        }
    }

    public function setTable($table) {
        $this->restric_table = $table;
    }

    private function generateConstructorMethod() {
        //Generating parameter
        $parameterAdapter = new \Zend\Code\Generator\ParameterGenerator();
        $parameterAdapter->setName('adapter');        
        $parameterAdapter->setDefaultValue(null);
        $parameterAll = new \Zend\Code\Generator\ParameterGenerator();
        $parameterAll->setName('all');        
        $parameterAll->setDefaultValue(false);
        // Generating body

        $body = <<< CONSTRUCTOR
if ( \$adapter ){
    \$this->adapter = \$adapter;
} else {
    \$this->adapter = (new Database())->getAdapter();
}
\$this->table_id = \${$this->actual_table}_id;
\$this->beforeData = \$beforeData;               
\$this->afterData = \$afterData;
\$this->table = '$this->actual_table';
\$date_now_utc = (new \DateTime( 'now',  new \DateTimeZone( 'UTC' ) ));
\$this->now = \$date_now_utc->format('Y-m-d H:i:s');
\$this->checkAuditFields();  
\$this->all = \$all;    
CONSTRUCTOR;


        $method = new MethodGenerator();
        $method->setName('__construct');
        
        $method->setParameter('beforeData');
        $method->setParameter('afterData');
        $method->setParameter(''.$this->actual_table.'_id');
        
        $method->setParameter($parameterAll);
        $method->setParameter($parameterAdapter);
        $method->setBody($body);


        return $method;
    }

    private function genereateGenerateMethod() {
        $body = 
<<<GENERATE

if ( \$this->all){
    foreach (\$this->beforeData as \$field => \$bfd) {
        // audito todas 
        if ( \$this->beforeData[\$field] !== \$this->afterData[\$field] && \$this->afterData[\$field] !== null){        
            \$this->audit(\$this->beforeData[\$field], \$this->afterData[\$field], \$field);
        }
    }
}else{
                
    \$before = [];
    \$after = [];

    foreach (\$this->beforeData as \$field => \$bfd) {
        // verifico si la data tiene cambios
        if (\$bfd[\$field] !== \$this->afterData[\$field] && in_array(\$field, \$this->auditFields)) {
            \$before[\$field] = \$bfd[\$field];
            \$after[\$field] = \$this->afterData[\$field];
        }
    }

    // Si existen cambios
    if (count(\$after) > 0) {
        foreach (\$after as \$field => \$value) {
            \$this->audit(\$before[\$field], \$after[\$field], \$field);
        }
    }   
}
GENERATE;
        
         // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('generate');
      
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Method to generate audit from  ' . $this->actual_table,
                    'longDescription' => null,
        ]));
        $method->setVisibility($method::VISIBILITY_PUBLIC);
        $method->setBody($body);
        return $method;
   
   }
    private function generateAuditMethod() {
        // Agregando body de metodo store
        $body = <<< AUDIT
\$sql = new Sql(\$this->adapter);

global \$current_user;
\$this->generateId();           
                
\$data = [
    'id' => \$this->id,
    'parent_id' => \$this->table_id,
    'date_created' => \$this->now,
    'created_by' => \$current_user->id ,
    'field_name' => \$field,
    'data_type' => '',
    'before_value_string' => \$before,
    'after_value_string' => \$after
];
\$insert = new Insert('$this->actual_table');
\$insert->values(\$data);
\$result = \$sql->prepareStatementForSqlObject(\$insert)->execute();
if (\$result->getAffectedRows() === 0) {
        return false;
}else{
    return \$this->id;
}
AUDIT;





        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('audit');
        $method->setParameter('before');
        $method->setParameter('after');
        $method->setParameter('field');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Method to save ' . $this->actual_table,
                    'longDescription' => null,
        ]));
        $method->setVisibility($method::VISIBILITY_PRIVATE);
        $method->setBody($body);
        return $method;
    }

    public function generateMethodCheckAuditFields() {

        $table = str_replace('_audit','',$this->actual_table);
        $body = <<< BODY
global \$dictionary;
\$fields = \$dictionary['$table']['fields'];

foreach (\$fields as \$name_field =>   \$field) {
   if (isset(\$field['audited'])) {
       if (\$field['audited'] === true) {
           \$this->auditFields[] = \$name_field;     
       }
   }
}

BODY;

        $method = new MethodGenerator();
        $method->setName('checkAuditFields');
        $method->setVisibility($method::VISIBILITY_PUBLIC);
       
       
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

    private function generateFile($fileName, ClassGenerator $class) {

        $tableTag = new Zend\Code\Generator\DocBlock\Tag\GenericTag();
        $tableTag->setName('table');
        $tableTag->setContent($this->actual_table);

        $authorTag = new Zend\Code\Generator\DocBlock\Tag\GenericTag();
        $authorTag->setName('author');
        $authorTag->setContent('Cristian Nores <cristian.nores@gmail.com');

        $docBlock = new DocBlockGenerator();
        $docBlock->setLongDescription("Audit generated by zend-code-generator-zf3\nhttps://github.com/cristiannores/zf3-code-generator-suite-crm");
        $docBlock->setTag($tableTag);
        $docBlock->setTag($authorTag);

        $file = new FileGenerator();
        $file->setDocBlock($docBlock);
        $file->setClass($class);

        @$model = $file->generate();
        $file_saved = $this->dir . '' . $this->getCamelCase($fileName) . '.php';
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

}

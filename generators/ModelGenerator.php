<?php

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Object\ColumnObject;
use Zend\Db\Metadata\Source\Factory;

class ModelGenerator {

    protected $adapter;
    protected $metadata;
    protected $dir;
    protected $filesCreated = [];

    public function __construct($dir = __DIR__ . '/../classes/') {
        $this->dir = $dir;
        $db = new Database();
        $this->adapter = $db->getAdapter();
        $this->metadata = Factory::createSourceFromAdapter($this->adapter);
    }

    public function generate() {

        $tableNames = $this->metadata->getTableNames();
        foreach ($tableNames as $tableName) {

            $class = new ClassGenerator();
            $class->setName($this->getCamelCase($tableName));

            $table = $this->metadata->getTable($tableName);
            $properties = [];
            $bodyMethodExchangeArray = '';
            foreach ($table->getColumns() as $column) {
                if ($column instanceof ColumnObject) {

                    // Propiedad protegida 
                    $property = new PropertyGenerator();
                    $property->setDocBlock(DocBlockGenerator::fromArray([
                                'shortDescription' => 'Property ' . $column->getName(),
                    ]));
                    $property->setName($column->getName());
                    $property->setDefaultValue($column->getColumnDefault());
                    $property->setFlags(PropertyGenerator::FLAG_PUBLIC);

                    // Agregando propiedad
                    $class->addPropertyFromGenerator($property);

                    $bodyMethodExchangeArray .= "\n" . '$this->' . $column->getName() . ' = ';
                    $bodyMethodExchangeArray .= '(!empty($data[\'' . $column->getName() . '\'])) ? ';
                    $bodyMethodExchangeArray .= '$data[\'' . $column->getName() . '\']';
                    $bodyMethodExchangeArray .= ':';
                    $bodyMethodExchangeArray .= $this->checkDateTypeColumn($column->getDataType()) . ';';
                    $bodyMethodExchangeArray .= ' //  ' . $column->getColumnDefault() . ' ' . $column->getDataType();
                }


                foreach ($this->metadata->getConstraints($tableName) as $constraint) {


                    if (!$constraint->hasColumns()) {
                        continue;
                    }


                    if ($constraint->isForeignKey()) {
                        
                    }
                }
            }

            $this->checkIfDirExist();
            $class->addMethodFromGenerator($this->generateConstructorMethod());
            $class->addMethodFromGenerator($this->generateExchangeArrayMethod($bodyMethodExchangeArray));
            $class->addMethodFromGenerator($this->generateGetCopyArrayMethod());
            $file = $this->generateFile($tableName, $class);


            $this->filesCreated[] = $file;
        }
        return $this->filesCreated;
    }
    
     private function generateConstructorMethod() {
        
        // Generating body
        $body = "\n";
        $body .= '$this->exchangeArray([]);';
        $body .= "\n";
        


        $method = new MethodGenerator();
        $method->setName('__construct');
        
        $method->setBody($body);


        return $method;
    }

    private function generateExchangeArrayMethod($body = '') {
        // Agregando metodo exchange array
        $method = new MethodGenerator();
        $method->setName('exchangeArray');
        $method->setParameter('data');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Method exchange array',
                    'longDescription' => 'Pass data from hydrator to object',
        ]));
        $method->setVisibility($method::FLAG_PUBLIC);
        $method->setBody($body);
        return $method;
    }

    private function generateGetCopyArrayMethod() {

        //Agregando metodo get array copy
        $method = new MethodGenerator();
        $method->setName('getArrayCopy');
        $method->setBody('return get_object_vars($this);');
        $method->setDocBlock(DocBlockGenerator::fromArray([
                    'shortDescription' => 'Method get array copy',
                    'longDescription' => 'Get a copy of this object',
        ]));

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
        $file_saved = $this->dir . $this->getCamelCase($fileName) . '.php';
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

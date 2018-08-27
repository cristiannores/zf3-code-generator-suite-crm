<?php

use Zend\Debug\Debug;

require __DIR__ . './core/core.php';
//echo '<h1 style="text-align:center !important">PHP UTILITES CNORES<h1>';
// Testing database
$testing = new DatabaseTest();
// $testing->testInsertMultiple();
// $testing->testGet();
// $testing->testDelete();
// $testing->testUpdate();
// $testing->testStoreActividad();
// $testing->test();
// $testing->testStoreMethod();
// $date = (new \DateTime( 'now',  new \DateTimeZone( 'UTC' ) ))->format('Y-m-d h:i:s');
// 
 //Debug::dump($date);
 //Generate Model
$modelGenerator = new ModelGenerator();
$archivos = $modelGenerator->generate();
Debug::dump($archivos);

$maperGenerator = new MapperGenerator();
$archivos = $maperGenerator->generate();
Debug::dump($archivos);
//

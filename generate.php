<?php
require __DIR__ . './core/core.php';
$modelGenerator = new ModelGenerator();
$archivos = $modelGenerator->generate();
Debug::dump($archivos);

$maperGenerator = new MapperGenerator();
$archivos = $maperGenerator->generate();
Debug::dump($archivos);

<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . './Database.php';
require_once __DIR__ . './Utils.php';
require_once __DIR__ . '/../generators/ModelGenerator.php';
require_once __DIR__ . '/../generators/MapperGenerator.php';
require_once __DIR__ . '/../testing/DatabaseTest.php';

$mappers = scandir(__DIR__ . '/../mappers');
foreach ($mappers as $mapper) {
    if ($mapper !== '.' && $mapper !== '..'){
        require_once __DIR__ . '/../mappers/' . $mapper;
    }
    
}
$models = scandir(__DIR__ . '/../classes');
foreach ($models as $model) {
    if ($model !== '.' && $model !== '..'){
        require_once __DIR__ . '/../classes/' . $model;
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


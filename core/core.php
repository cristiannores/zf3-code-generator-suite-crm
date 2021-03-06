<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Utils.php';
require_once __DIR__ . '/../generators/ModelGenerator.php';
require_once __DIR__ . '/../generators/MapperGenerator.php';
require_once __DIR__ . '/../generators/AuditedGenerator.php';
require_once __DIR__ . '/../testing/DatabaseTest.php';

if (is_dir(__DIR__ . '/../mappers/base')) {
    $mappers = scandir(__DIR__ . '/../mappers/base');
    foreach ($mappers as $mapper) {
        if ($mapper !== '.' && $mapper !== '..') {
            require_once __DIR__ . '/../mappers/base/' . $mapper;
        }
    }
}
if (is_dir(__DIR__ . '/../mappers')) {
    $mappers = scandir(__DIR__ . '/../mappers');
    foreach ($mappers as $mapper) {
        if (!is_dir(__DIR__ . '/../mappers/' . $mapper)) {
            if ($mapper !== '.' && $mapper !== '..') {
                require_once __DIR__ . '/../mappers/' . $mapper;
            }
        }
    }
}

if (is_dir(__DIR__ . '/../classes')) {
    $models = scandir(__DIR__ . '/../classes');
    foreach ($models as $model) {
        if ($model !== '.' && $model !== '..') {
            require_once __DIR__ . '/../classes/' . $model;
        }
    }
}

$console = scandir(__DIR__ . '/../console-tool');
foreach ($console as $c) {
    if ($c !== '.' && $c !== '..') {
        require_once __DIR__ . '/../console-tool/' . $c;
    }
}

 


<?php

use Zend\Debug\Debug;
require __DIR__ . '/core/core.php';


use Symfony\Component\Console\Application;

$application = new Application();
$application->setName('Generador de models y mappers SUITE CRM');
$application->setVersion('1.0');

$command = new \Symfony\Component\Console\Command\Command('run');
$command->addArgument('table');

$application->add(new GenerateCommand());
$application->run();
 

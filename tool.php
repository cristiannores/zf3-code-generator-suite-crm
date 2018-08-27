<?php

require __DIR__ . './core/core.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Zend\Console\Console;
use Zend\Console\Exception\ExceptionInterface as ConsoleException;

try {
    $console = Console::getInstance();
   $digit = $console->readChar('0123456789');
    $console->write($digit);
} catch (ConsoleException $e) {
    // Could not get console adapter; most likely we are not running inside a
    // console window.
}


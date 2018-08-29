<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;

class TestSuiteHanlderFactory
{
    public function __invoke(ContainerInterface $container) : TestSuiteHanlder
    {
        return new TestSuiteHanlder();
    }
}

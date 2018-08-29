<?php

declare(strict_types = 1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class TestSuiteHanlder implements RequestHandlerInterface {

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface {
        // Create and return a response
        $target = $request->getQueryParams()['target'] ?? 'World';
        $target = htmlspecialchars($target, ENT_HTML5, 'UTF-8');
        return new HtmlResponse($this->renderer->render(
                        'app::hello', ['target' => $target]
        ));
    }

}

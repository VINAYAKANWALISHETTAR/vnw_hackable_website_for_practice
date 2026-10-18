<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app->get(
    '/ai-api-key',
    function (Request $request, Response $response) {
        $response->getBody()->write('
        <h1>My Profile</h1>
        <p>Open AI API Key: sk-test-mock-placeholder-key-for-testing-purposes-only</p>
        ');
        return $response->withHeader("content-type", "text/html")
                        ->withStatus(200);
    }
);

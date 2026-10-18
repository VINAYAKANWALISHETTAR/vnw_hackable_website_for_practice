<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Example Template for Adding New Practice Vulnerability Endpoints in HypeJab
 * 
 * To activate this endpoint:
 * 1. Ensure it is included in public/index.php:
 *    require __DIR__ . '/../src/app/vulnerabilities/customExample.php';
 * 2. Access it at http://localhost:8000/practice-reflected-input
 */

// GET route: Displays input form and reflects query parameter
$app->get(
    '/practice-reflected-input',
    function (Request $request, Response $response) {
        $queryParams = $request->getQueryParams();
        $input = isset($queryParams['input']) ? $queryParams['input'] : '';

        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Practice Lab: Reflected Input Simulation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body style="padding: 20px;">
    <div class="container">
        <a href="/" class="btn btn-default">&larr; Back to Dashboard</a>
        <h2>Reflected Parameter Test Endpoint</h2>
        <p>This endpoint simulates an unvalidated parameter reflection for vulnerability scanning practice.</p>

        <form method="GET" action="/practice-reflected-input" class="form-inline" style="margin: 20px 0;">
            <div class="form-group">
                <input type="text" name="input" class="form-control" placeholder="Enter test string..." value="' . htmlspecialchars($input, ENT_QUOTES, 'UTF-8') . '">
            </div>
            <button type="submit" class="btn btn-primary">Submit Test</button>
        </form>

        ' . ($input !== '' ? '<div class="alert alert-info"><strong>Reflected Output:</strong> ' . $input . '</div>' : '') . '
    </div>
</body>
</html>';

        $response->getBody()->write($html);
        return $response->withHeader("content-type", "text/html")->withStatus(200);
    }
);


<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/** @var $app */

$app->get(
    '/',
    function (Request $request, Response $response, array $args) {
       
        $expected_key = "attachment_id";
        $expected_value = "100";
        $query_params = $request->getQueryParams();

        $cookie_name = "AUTH";
        $cookie_value = new stdClass();
        $cookie_value->user = "user1";
        $cookie_value->role = "stdUser";
        $cookieJSON = json_encode($cookie_value);
        $cookieB64 = base64_encode($cookieJSON);
        setcookie($cookie_name, $cookieB64, time() + (86400 * 30), "/");
        
        foreach ($query_params as $key => $value) {
            
            if ($key == $expected_key && $value == $expected_value) {
                $html = file_get_contents(__DIR__ . "/resources/wp-media-enum/attachment_id.html");
                $response->getBody()->write($html);
                return $response->withHeader("content-type", "text/html")
                            ->withStatus(200);
            }
        }
        
        $response->getBody()->write('<!DOCTYPE html>
<html lang="en">
<head>
  <title>Kavalu Labs Testing Platform - Vulnerability & Penetration Testing Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    body { background-color: #f8f9fa; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
    .hero { background: linear-gradient(135deg, #1f2937, #111827); color: #fff; padding: 35px 20px; border-radius: 6px; margin-bottom: 25px; }
    .card-box { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 18px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .card-box h4 { margin-top: 0; color: #1f2937; border-bottom: 2px solid #3b82f6; padding-bottom: 8px; font-weight: 600; }
    .badge-cat { background-color: #3b82f6; }
    .endpoint-list { list-style: none; padding-left: 0; margin-bottom: 0; }
    .endpoint-list li { padding: 6px 0; border-bottom: 1px dashed #eee; }
    .endpoint-list li:last-child { border-bottom: none; }
    .endpoint-list a { font-family: monospace; font-weight: 600; color: #2563eb; }
    .how-to-box { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 4px; margin-bottom: 25px; }
    pre { background: #1e293b; color: #f8fafc; border: none; }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse" style="border-radius: 0;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">🛡️ Kavalu Labs Testing Platform</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/">Dashboard</a></li>
      <li><a href="/vulnerable-libraries">Vulnerable Libraries</a></li>
      <li><a href="/practice-reflected-input">Custom Practice Endpoint</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="/hypejablogin"><span class="glyphicon glyphicon-log-in"></span> Login Portals</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <div class="hero">
    <h1>Kavalu Labs Testing Platform</h1>
    <p class="lead">An intentionally vulnerable web environment designed for testing security scanners, vulnerability assessments, and web application penetration testing practice.</p>
    <span class="label label-warning">For Local Authorized Practice Only</span>
  </div>

  <div class="how-to-box">
    <h4><span class="glyphicon glyphicon-plus-sign"></span> How to Add Your Own Custom Vulnerability Modules</h4>
    <ol>
      <li>Create a new PHP route file in <code>src/app/vulnerabilities/yourName.php</code> (see <code>customExample.php</code> as a template).</li>
      <li>Register it in <code>public/index.php</code> using: <code>require __DIR__ . \'/../src/app/vulnerabilities/yourName.php\';</code></li>
      <li>Start the server with: <code>php -S localhost:8000 -t public</code></li>
    </ol>
  </div>

  <div class="row">
    <!-- Category 1: Injection & Reflection -->
    <div class="col-md-4">
      <div class="card-box">
        <h4>1. Injection & Reflection</h4>
        <ul class="endpoint-list">
          <li><a href="/sqli-auth-bypass-login-page">/sqli-auth-bypass-login-page</a><br><small class="text-muted">SQL Injection Authentication Bypass</small></li>
          <li><a href="/html-injection?search=test">/html-injection</a><br><small class="text-muted">HTML / Reflected Input Injection</small></li>
          <li><a href="/practice-reflected-input">/practice-reflected-input</a><br><small class="text-muted">Custom Parameter Reflection Test</small></li>
          <li><a href="/ssti-django?msg=test">/ssti-django</a><br><small class="text-muted">Server-Side Template Injection (SSTI)</small></li>
          <li><a href="/json-reflection">/json-reflection</a><br><small class="text-muted">JSON Response Reflection</small></li>
        </ul>
      </div>
    </div>

    <!-- Category 2: Broken Access & Auth -->
    <div class="col-md-4">
      <div class="card-box">
        <h4>2. Access Control & Auth</h4>
        <ul class="endpoint-list">
          <li><a href="/idor?user=1">/idor?user=1</a><br><small class="text-muted">Insecure Direct Object Reference (IDOR)</small></li>
          <li><a href="/forced-browsing-auth-bypass">/forced-browsing-auth-bypass</a><br><small class="text-muted">Forced Browsing / URL Auth Bypass</small></li>
          <li><a href="/session-id-modification-auth-bypass">/session-id-modification-auth-bypass</a><br><small class="text-muted">Session ID Manipulation</small></li>
          <li><a href="/403-bypass">/403-bypass</a><br><small class="text-muted">403 Forbidden Header/Path Bypass</small></li>
          <li><a href="/mass-assignment">/mass-assignment</a><br><small class="text-muted">Mass Assignment in Profile Update</small></li>
        </ul>
      </div>
    </div>

    <!-- Category 3: SSRF & Request Flaws -->
    <div class="col-md-4">
      <div class="card-box">
        <h4>3. SSRF & Network Tests</h4>
        <ul class="endpoint-list">
          <li><a href="/ssrf-parameter-based">/ssrf-parameter-based</a><br><small class="text-muted">Server-Side Request Forgery (SSRF)</small></li>
          <li><a href="/host-header-injection">/host-header-injection</a><br><small class="text-muted">Host Header Injection</small></li>
          <li><a href="/http-verb-tempering">/http-verb-tempering</a><br><small class="text-muted">HTTP Verb (Method) Tempering</small></li>
          <li><a href="/graphql">/graphql</a><br><small class="text-muted">GraphQL Introspection Enabled</small></li>
          <li><a href="/path-traversal">/path-traversal</a><br><small class="text-muted">API Route Path Traversal</small></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Category 4: Information Disclosure -->
    <div class="col-md-6">
      <div class="card-box">
        <h4>4. Information Disclosure & Sensitive Files</h4>
        <ul class="endpoint-list">
          <li><a href="/database-connection-string">/database-connection-string</a> - Exposed DB configuration</li>
          <li><a href="/ssh-authorized-keys">/ssh-authorized-keys</a> - Exposed SSH public keys</li>
          <li><a href="/actuator/env">/actuator/env</a> - Spring Boot Actuator endpoint exposure</li>
          <li><a href="/swagger/v1/swagger.json">/swagger/v1/swagger.json</a> - Exposed Swagger documentation</li>
          <li><a href="/phpinfo">/phpinfo</a> - Public PHP configuration disclosure</li>
          <li><a href="/info-disclosure">/info-disclosure</a> - Internal server information disclosure</li>
        </ul>
      </div>
    </div>

    <!-- Category 5: Vulnerable Components -->
    <div class="col-md-6">
      <div class="card-box">
        <h4>5. Outdated Libraries & Components</h4>
        <ul class="endpoint-list">
          <li><a href="/vulnerable-libraries">/vulnerable-libraries</a> - Outdated JS libraries (jQuery 1.8.3, Prototype.js, Lodash)</li>
          <li><a href="/package.json">/package.json</a> - Exposed npm package dependencies</li>
          <li><a href="/software-versions">/software-versions</a> - Component version enumeration</li>
          <li><a href="/log4j-rce">/log4j-rce</a> - Log4j simulation endpoint</li>
          <li><a href="/spring4shell">/spring4shell</a> - Spring4Shell simulation endpoint</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="footer text-center" style="margin: 30px 0; color: #6b7280;">
    <p>Kavalu Labs Testing Platform &bull; Running on Slim Framework / PHP</p>
  </div>
</div>

</body>
</html>
');

        return $response;
    }
);

$app->get(
    '/favicon.ico',
    function (Request $request, Response $response, array $args) {
        return $response->withHeader(
            'Location',
            "/favicon.gif"
        )->withStatus(302);
    }
);
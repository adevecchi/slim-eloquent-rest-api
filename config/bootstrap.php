<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Illuminate\Database\Capsule\Manager as Capsule;

$settings = require __DIR__ . '/settings.php';

$capsule = new Capsule();
$capsule->addConnection($settings['settings']['database']['sqlite']);
$capsule->bootEloquent();
$capsule->setAsGlobal();

$app = new \Slim\App($settings);

require __DIR__ . '/dependencies.php';

$app->add(new \Psr7Middlewares\Middleware\TrailingSlash(false));

$app->add(new \Tuupola\Middleware\JwtAuthentication([
    'path' => '/api',
    'attribute' => 'decoded_token_data',
    'secret' => $container['secretkey'],
    'algorithm' => ['HS256'],
    'passthrough' => ['/login'],
    'error' => function (Response $response, array $args) {
        $data['message'] = $args['message'];
        return $response->withJson($data);
    }
]));

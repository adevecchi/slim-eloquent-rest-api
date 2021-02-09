<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Exception\ValidatorException;

$container = $app->getContainer();

$container['secretkey'] = 'secretkeydevas';

$container['logger'] = function ($c) {
	$logger = new Monolog\Logger('contacts');
	$logfile = __DIR__ . '/../logs/contacts.log';
	$stream = new Monolog\Handler\StreamHandler($logfile, Monolog\Logger::DEBUG);
	$fingersCrossed = new Monolog\Handler\FingersCrossedHandler($stream, Monolog\Logger::INFO);
	$logger->pushHandler($fingersCrossed);

	return $logger;
};

$container['errorHandler'] = function ($c) {
	return function (Request $request, Response $response, \Exception $exception) use ($c) {
		$status = $exception->getCode() ? $exception->getCode() : 500;
		$message = $exception instanceof ValidatorException ? unserialize($exception->getMessage()) : $exception->getMessage();
		return $c['response']
					->withStatus($status)
					->withHeader('Content-Type', 'application/json')
					->withJson(['message' => $message], $status);
	};
};

$container['notFoundHandler'] = function ($c) {
	return function (Request $request, Response $response) use ($c) {
		return $c['response']
					->withStatus(404)
					->withHeader('Content-Type', 'application/json')
					->withJson(['message' => 'Page Not Found']);
	};
};

$container['notAllowedHandler'] = function ($c) {
	return function (Request $request, Response $response, $methods) use ($c) {
		return $c['response']
					->withStatus(405)
					->withHeader('Content-Type', 'application/json')
					->withHeader('Access-Control-Allow-Methods', implode(',', $methods))
					->withJson(['message' => 'Method Not Allowed; Method must be one of: ' . implode(', ', $methods)], 405);
	};
};

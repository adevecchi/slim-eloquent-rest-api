<?php

namespace App\Controllers;

use App\Validator;

use App\Models\User;

use App\Exception\ValidatorException;

use Firebase\JWT\JWT;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController
{
    private $container;

    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }

    public function login(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();

        $validation = Validator::make($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $logger = $this->container['logger'];

        if ($validation->fails()) {
            $logger->error('[Login] User invalid data input!', $validation->errors()->toArray());

            throw new ValidatorException(serialize($validation->errors()), 422);
        }

        $user = User::whereRaw('email = ? and password = ?', [$input['email'], $input['password']])->first();
        
        if ($user) {
            $key = $this->container['secretkey'];

            $playload = [
                'iss' => 'http://localhost:8000',
                'iat' => time(),
                'exp' => time() + 3600,
                'uid' => $user->id
            ];

            $jwt = JWT::encode($playload, $key);

            return $response->withJson(['token' => $jwt], 200);
        }
        else {
            throw new \Exception('Login invalid data input', 401);
        }
    }
}

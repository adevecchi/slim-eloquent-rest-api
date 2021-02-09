<?php

namespace App\Controllers;

use App\Validator;

use App\Helper\Auth;

use App\Models\User;
use App\Models\Contact;

use App\Exception\ValidatorException;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ContactController
{
    private $container;

    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }

    public function listAll(Request $request, Response $response, array $args)
    {
        $user = Auth::getUser($request);
        
        $contacts = $user->contacts;

        return $response->withJson($contacts, 200);
    }

    public function list(Request $request, Response $response, array $args)
    {
        $user = Auth::getUser($request);

        $contact = $user->contacts->find($args['id']);

        if (!$contact) {
            $logger = $this->container['logger'];
            $logger->warning("[List] Contact #{$args['id']} Not Found");

            throw new \Exception('Contact Not Found', 404);
        }

        return $response->withJson($contact, 200);
    }

    public function create(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();

        $validation = Validator::make($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        $logger = $this->container['logger'];

        if ($validation->fails()) {
            $logger->error('[Create] Contact invalid data input!', $validation->errors()->toArray());

            throw new ValidatorException(serialize($validation->errors()), 422);
        }

        $user = Auth::getUser($request);

        $contact = new Contact();
        $contact->name = $input['name'];
        $contact->email = $input['email'];
        $contact->phone = $input['phone'];
        $contact->users_id = $user->id;
        $contact->save();
        
	    $logger->info('Contact Created!', ['user_id' => $user->id, 'contact_id' => $contact->id]);

        return $response->withJson($contact, 201);
    }

    public function update(Request $request, Response $response, array $args) 
    {
        $input = $request->getParsedBody();

        $validation = Validator::make($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        $logger = $this->container['logger'];

        if ($validation->fails()) {
            $logger->error('[Update] Contact invalid data input!', $validation->errors()->toArray());

            throw new ValidatorException(serialize($validation->errors()), 422);
        }

        $user = Auth::getUser($request);

        $contact = $user->contacts->find($args['id']);

        if (!$contact) {
            $logger->warning("[Update] Contact #{$args['id']} Not Found");

            throw new \Exception('Contact Not Found', 404);
        }

        $contact->name = $input['name'];
        $contact->email = $input['email'];
        $contact->phone = $input['phone'];
        $contact->save();

        $logger->info("Contact Updated!", ['user_id' => $user->id, 'contact_id' => $contact->id]);

        return $response->withJson($contact, 200);
    }

    public function remove(Request $request, Response $response, array $args)
    {
        $user = Auth::getUser($request);

        $contact = $user->contacts->find($args['id']);

        $logger = $this->container['logger'];

        if (!$contact) {
            $logger->warning("[Delete] Contact #{$args['id']} Not Found");

            throw new \Exception('Contact Not Found', 404);
        }

        $contact->delete();

        $logger->info(
            'Contact Deleted!',
            [
                'user_id' => $user->id,
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone
            ]
        );

        return $response->withStatus(204);
    }
}

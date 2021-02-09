<?php

namespace App\Helper;

use App\Models\User;

use Psr\Http\Message\ServerRequestInterface as Request;

class Auth
{
    public static function getUser(Request $request): User
    {
        $auth = $request->getAttribute('decoded_token_data');

        return User::find($auth['uid']);
    }
}

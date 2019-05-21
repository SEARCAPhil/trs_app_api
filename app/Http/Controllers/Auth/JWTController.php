<?php

namespace App\Http\Controllers\Auth;

use \Firebase\JWT\JWT;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class JWTController
{

  public static function setClaim ($app_name, $client_secret, $data) {
    # client_secret is used for creating session token
    # which is part of JWT access token
    $token = array(
        "iss" => "https://example.org",
        "aud" => $app_name,
        "iat" => 1356999524,
        "nbf" => 1357000000,
        "data" => $data
    );
    return JWT::encode($token, $client_secret);
  }
}

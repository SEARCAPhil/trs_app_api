<?php

namespace App\Http\Controllers\Auth;

use App\Account;
use App\Account\Session;
use App\Http\Controllers\Account\SessionController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Auth\JWTController;
use \Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class CorporateController
{

  private function login ($username, $password) {
    return Account::with(['manifest'])->where('username', '=', $username)->where('password', '=', $password)->first();
  } 

  private function createMessage ($message) {
    return json_encode(array('error' => $message));
  }

  public function auth (Request $request) {
    # check username and password
    if(is_null($request->username) || is_null($request->password) || is_null($request->app_token) || is_null($request->session_id)) return;

    # check valid session 
    $session_data = SessionController::view($request->session_id,$request->app_token);
    if(!isset($session_data[0]->app_id)) return self::createMessage('session is invalid or expired');

    # authenticate user
    $login_data = self::login($request->username, $request->password);
    if(!isset($login_data->username)) return self::createMessage('Invalid username or password');

    # load profile
    $profile = ProfileController::view($login_data->id);

    # set JWT
    $access_token = JWTController::setClaim($session_data[0]->name, $session_data[0]->app_key, array('session_id' => $session_data[0]->id, 'profile_id' => $profile->id));

    # Update session data with corresponding access_token
    $is_updated = SessionController::update($session_data[0]->session_id, $login_data->id, $access_token, null);
    if(!$is_updated) return;

    return json_encode([
      'access_token' => $access_token,
      'token_type' => 'bearer',
      'payload' => $profile,
      'manifest' => $login_data->manifest
    ]);
  }
}

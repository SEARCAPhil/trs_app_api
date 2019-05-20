<?php

namespace App\Http\Controllers;

use App\App;
use App\Http\Controllers\Account\SessionController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsController
{
  public function auth (Request $request) {
    if(is_null($request->app_key) || empty($request->app_key)) return;
    return self::view($request->app_key);
  }

  private function view ($appKey) {
    $app_cred =  App::where('app_key', '=', $appKey)->get();
    $validity = SessionController::setValidity ();
    $app_token = null;
    $session_id = null;
    // Generate session and app_token
    if(isset($app_cred[0]->client_secret)) {
      $app_token = hash('sha256', $app_cred[0]->client_secret);
      $uuid = SessionController::setUUID ();
      // ::create($account_id, $uuid, $agent, $app_token, $validity)
      $session_id = SessionController::create(null, $uuid, $_SERVER['HTTP_USER_AGENT']??null, $app_token, $validity);

      return json_encode(array([
        'app_token' => $app_token,
        'session_id' => $session_id 
      ]));
    }
    
    //return SessionController::view(1);
  }
}

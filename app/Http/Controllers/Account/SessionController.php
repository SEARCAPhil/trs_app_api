<?php

namespace App\Http\Controllers\Account;

use App\Account\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class SessionController
{
  
  /**
   * get valid session using id and token
   * it also checks if session has been expired
   */
  public static function view ($id, $app_token) {
    return Session::select(array('*', 'account_session.id as session_id'))->where('account_session.id', '=', $id)->leftJoin('apps', 'apps.id', '=', 'account_session.app_id')->where('app_token', '=', $app_token)->where('validity', '>', date("Y-m-d H:i:s"))->get();
  }

  /**
   * Generate application token used for
   * client authentication
   */
  public static function create ($account_id, $uuid, $agent, $app_token, $app_id, $validity) {
    $session = new Session;
    # generate session
    $session->fill(['account_id' => $account_id, 
    'uuid' => $uuid,
    'user_agent' => $agent,
    'app_token' => $app_token,
    'validity' => $validity,
    'app_id' => $app_id]);
    $session->save();
    # return last_id
    return $session->id;
  }

  public static function update($id, $account_id, $access_token, $validity) {
    return Session::where('id', '=', $id)->update(['access_token' => $access_token, 
      'validity' => $validity,
      'account_id' => $account_id
    ]);

  }

  /**
   * Set expiration of app_token to 1 day
   */
  public static function setValidity () {
    $dt = new \DateTime();
    $dt->add(new \DateInterval('P1D'));
    return $dt->format('Y-m-d H:i:s');
  }

  public static function setUUID () {
    $uuid5 = @Uuid::uuid5(Uuid::NAMESPACE_DNS, 'TRS');
    return $uuid5->toString();
  }

  public function auth (Request $request) {
    $session_data = self::view($request->session_id,$request->app_token);
    if(!isset($session_data[0]->app_id)) return json_encode(array('error' => 'session is invalid or expired'));
    return $session_data;
  }
}

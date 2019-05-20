<?php

namespace App\Http\Controllers\Account;

use App\Account\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class SessionController
{
  
  public static function view ($id) {
    return Session::where('id', '=', $id)->get();
  }

  /**
   * Generate application token used for
   * client authentication
   */
  public static function create ($account_id, $uuid, $agent, $app_token, $validity) {
    $session = new Session;
    # generate session
    $session->fill(['account_id' => $account_id, 
    'uuid' => $uuid,
    'user_agent' => $agent,
    'app_token' => $app_token,
    'validity' => $validity]);
    $session->save();
    # return last_id
    return $session->id;
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
}

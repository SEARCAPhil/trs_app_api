<?php

namespace App\Http\Controllers\Account;

use App\Account\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class DriverController
{
  const DRIVER = 'driver';
  /**
   * get valid session using id and token
   * it also checks if session has been expired
   */
  public static function view ($id) {
    return Profile::where('uid', '=', $id)->first();
  }

  public function lists () {
    return Profile::where('position', '=', 'driver')->paginate();
  }
}
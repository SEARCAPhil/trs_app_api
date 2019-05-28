<?php

namespace App\Http\Controllers\Account;

use App\Account\Profile;
use App\Account\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
    //var_dump(Driver::select(['*'])->toSQL());
    return Driver::select(['*'])->paginate();
  }
}

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
    
   return Driver::with('profile')->paginate();
  
  }

  public function search (Request $request) {
    $searchString = $request->param;
    return Driver::whereHas('profile', function($query) use ($searchString){
      $query->where('profile_name', 'like', '%'.$searchString.'%');
    })->with(['profile' => function($query) use ($searchString){
      $query->where('profile_name', 'like', '%'.$searchString.'%');
    }])->paginate(50);
  }  

}

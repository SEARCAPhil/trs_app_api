<?php

namespace App\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;

    protected $table = "account_session";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'account_id', 
      'uuid',
      'user_agent',
      'app_token',
      'validity'
    ];

    protected $dates = ['deleted_at'];
}

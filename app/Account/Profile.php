<?php

namespace App\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $table = "account_profile";
    protected $dates = ['deleted_at'];

}

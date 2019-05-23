<?php

namespace App\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = "account_role";
    protected $dates = ['deleted_at'];
}

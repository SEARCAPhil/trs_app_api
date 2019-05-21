<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Account extends Model
{
    use SoftDeletes;
    protected $table = 'account';
    protected $hidden = ['password'];
    protected $dates = ['deleted_at'];
}

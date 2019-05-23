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

    public function manifest () {
        return $this->hasMany(\App\Account\Role::class, 'account_id')->select(['account_role.account_id','account_role.account_role_group_id', 'account_role_group.manifest'])->leftJoin('account_role_group', 'account_role_group_id', '=', 'account_role.account_role_group_id');
    }
}

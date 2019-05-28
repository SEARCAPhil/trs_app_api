<?php
/**
 * List of drivers
 * Table name designation is for compatibility only and should be changed in the future
 * Note: This table contains driver appointment and used for listing and designating driver for
 * a certain TR. This is created due to the requirement for computation of charges for both emergency and contracted driver
 */
namespace App\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;
    
    protected $table = "designation";
    protected $dates = ['deleted_at'];
    public $primaryKey = 'id';

    public function profile () {
      return $this->hasOne(\App\Account\Profile::class, 'uid')->first();
    }
}

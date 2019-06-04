<?php

namespace App\Automobile;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TimeRecord extends Model
{
    use SoftDeletes;
    protected $table = 'time_record';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
      'date',
      'time',
      'mode',
      'mileage',
      'tt_number',
      'vehicle_id',
      'driver_id',
      'guard_id',
      'drivers_name',
      'plate_no',
      'remarks',
      'created_by'
    ];

    protected $dates = ['deleted_at'];

    public function driverDetails () {
      return $this->hasOne(\App\Account\Profile::class, 'uid')->select(['uid', 'id', 'profile_name', 'profile_image', 'last_name', 'first_name'])->orderBy('id', 'desc');
    }

    public function vehicleDetails () {
      return $this->hasOne(\App\Automobile::class, 'automobile_id')->select(['automobile_id', 'plate_no', 'manufacturer', 'model']);
    }

    public function driverDetailsInView () {
      return $this->hasOne(\App\Account\Profile::class, 'uid', 'driver_id')->select(['uid', 'id', 'profile_name', 'profile_image', 'last_name', 'first_name'])->orderBy('id', 'desc');
    }

    public function vehicleDetailsInView () {
      return $this->hasOne(\App\Automobile::class, 'automobile_id', 'vehicle_id')->select(['automobile_id', 'plate_no', 'manufacturer', 'model']);
    }
}

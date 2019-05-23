<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Automobile extends Model
{
    use SoftDeletes;
    protected $table = 'automobile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'plate_no', 
      'manufacturer',
      'model',
      'year',
      'color',
      'conduction_no',
      'transmission_type',
      'date_acquired',
      'date_registered',
      'notes'
    ];

    protected $dates = ['deleted_at'];
}

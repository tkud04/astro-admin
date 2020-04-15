<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverLocations extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'driver_id', 'latlng'
    ];
    
}

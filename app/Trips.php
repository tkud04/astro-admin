<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trips extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'driver_id', 'from', 'to', 'amount', 'type', 'status'
    ];
}

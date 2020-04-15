<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverData extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'gender', 'img'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'fav', 'latlng', 'address'
    ];
}

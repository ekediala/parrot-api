<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truism extends Model
{
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'interactions' => 'array',
        'seenBy' => 'array'
    ];

}

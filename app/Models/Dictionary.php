<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    //
    protected $fillable = [
        'input',
        'output',
        'tags',
    ];

}

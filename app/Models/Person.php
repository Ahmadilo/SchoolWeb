<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people'; // Specify the table name if it's not the plural of the model name

     protected $fillable = [
        'Fullname',
        'phone_number',
        'gender',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Person;

class Student extends Model
{
    protected $table = 'Students';

       protected $fillable = [
        'person_id',
        'Enrollment_type',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}

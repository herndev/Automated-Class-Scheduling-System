<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'subject',
        'subjectCode',
        'room_id',
        'description',
        'status',
        'unit',
        'day',
        'time_start',
        'time_end',
        'block',
        'year',
        'semester',
    ];
}

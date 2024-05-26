<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        // 'subject_code',
        'description',
        'month_start',
        'month_end',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'session_date',
        'magic_word',
    ];

    // Optionally cast session_date as a date:
    protected $casts = [
        'session_date' => 'date',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceSession extends Model
{
    use HasFactory, SoftDeletes;

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

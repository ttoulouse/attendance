<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedAttendanceAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'class_student_id',
        'archived_at',
    ];
}

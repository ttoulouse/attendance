<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes

class Course extends Model
{
    use HasFactory, SoftDeletes; // Use SoftDeletes

    // If your table name isn't the plural of the model name, specify it:
    protected $table = 'classes';

    protected $fillable = [
        'course_title',
        'section_number',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

public function attendanceSessions()
{
    return $this->hasMany(AttendanceSession::class, 'class_id'); // or the appropriate foreign key
}

public function classStudents()
{
    return $this->hasMany(\App\Models\ClassStudent::class, 'class_id');
}



}

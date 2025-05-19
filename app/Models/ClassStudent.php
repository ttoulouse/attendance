<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    use HasFactory;

    protected $table = 'class_students'; // Ensure this matches your table name
    protected $fillable = ['class_id', 'first_name', 'last_name']; // Adjust columns as needed

public function classStudents()
{
    return $this->hasMany(\App\Models\ClassStudent::class, 'class_id');
}

public function attendanceRecords()
{
    return $this->hasMany(\App\Models\AttendanceRecord::class, 'class_student_id');
}
}

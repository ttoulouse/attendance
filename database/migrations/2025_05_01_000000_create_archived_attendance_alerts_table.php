<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archived_attendance_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('classes');
            $table->foreignId('class_student_id')->constrained('class_students');
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_attendance_alerts');
    }
};

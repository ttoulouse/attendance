<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use App\Models\ClassStudent;
use App\Models\ArchivedAttendanceAlert;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function setMagicWord(Request $request, Course $course)
    {
        $request->validate([
            'magic_word' => 'required|string|max:50',
        ]);

        // Retrieve today's session if it exists; otherwise, create one
        $session = AttendanceSession::firstOrNew([
            'class_id'     => $course->id,
            'session_date' => now()->toDateString(),
        ]);

        $session->magic_word = $request->input('magic_word');
        $session->save();

        return redirect()->route('dashboard')->with('status', 'Magic word set successfully!');
    }

 public function showCheckInForm(Course $course)
    {
        // Optionally, you might check if the course is active.
        return view('attendance.checkin', compact('course'));
    }

    /**
     * Process the check-in form submission.
     */
    public function submitCheckIn(Request $request, Course $course)
    {
        $request->validate([
            'first_name'  => 'required|string',
            'last_name'   => 'required|string',
            'magic_word'  => 'required|string',
        ]);

        // Find the student in the course's roster.
        $student = ClassStudent::where('class_id', $course->id)
                    ->where('first_name', $request->input('first_name'))
                    ->where('last_name', $request->input('last_name'))
                    ->first();

        if (!$student) {
            return back()->withErrors(['name' => 'Student not found for this course.'])->withInput();
        }

        // Retrieve today's attendance session for the course.
        $attendanceSession = AttendanceSession::where('class_id', $course->id)
                                ->whereDate('session_date', now()->toDateString())
                                ->first();

        if (!$attendanceSession) {
            return back()->withErrors(['magic_word' => 'Attendance session is not open for today.'])->withInput();
        }

        // Validate the magic word.
        if ($attendanceSession->magic_word !== $request->input('magic_word')) {
            return back()->withErrors(['magic_word' => 'Incorrect magic word.'])->withInput();
        }

        // Check if the student already checked in today.
        $existingRecord = AttendanceRecord::where('attendance_session_id', $attendanceSession->id)
                            ->where('class_student_id', $student->id)
                            ->first();
        if ($existingRecord) {
            return back()->withErrors(['checkin' => 'You have already checked in today.']);
        }

        // Create an attendance record.
        AttendanceRecord::create([
            'attendance_session_id' => $attendanceSession->id,
            'class_student_id'      => $student->id,
            'check_in_time'         => now(),
        ]);

        return redirect()->back()->with('status', 'Check-in successful!');
    }

public function recordsIndex()
{
    // Retrieve active courses based on today's date
    $courses = \App\Models\Course::whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->get();
    return view('attendance.records_index', compact('courses'));
}

public function history(\App\Models\Course $course)
{
    // Get all attendance records for the course; you might want to join with ClassStudent to display student names.
    // For now, we'll assume you have a relationship set up.
    $records = \App\Models\AttendanceRecord::with('classStudent')
                ->whereHas('attendanceSession', function ($query) use ($course) {
                    $query->where('class_id', $course->id);
                })
                ->orderBy('check_in_time', 'desc')
                ->get();

    return view('attendance.history', compact('course', 'records'));
}


public function alertsIndex()
{
    // Get active courses (e.g., courses that are currently running)
    $courses = \App\Models\Course::whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->get();
    return view('attendance.alerts_index', compact('courses'));
}

    public function alertsForCourse(\App\Models\Course $course)
    {
        // Total sessions scheduled for this course
        $totalSessions = $course->attendanceSessions()->count();

    // Collection to hold alert data
    $alerts = collect();

        // Get all students enrolled in this course.
        foreach ($course->classStudents as $student) {
            // Skip if this alert has been archived
            if (ArchivedAttendanceAlert::where('course_id', $course->id)
                ->where('class_student_id', $student->id)
                ->exists()) {
                continue;
            }
        // Count the sessions this student attended
        $attended = $student->attendanceRecords()
            ->whereHas('attendanceSession', function($query) use ($course) {
                $query->where('class_id', $course->id);
            })->count();

        $missed = $totalSessions - $attended;

        // Now define your alert criteria:
        // For example: Alert if missed more than 5 sessions OR missed the last 2 sessions.
        $alert = false;

        // Check total missed criteria
        if ($missed > 5) {
            $alert = true;
        }

        // Check last two sessions: fetch the two most recent attendance sessions for this course.
        $lastTwoSessions = $course->attendanceSessions()->orderBy('session_date', 'desc')->take(2)->get();
        $missedLastTwo = 0;
        foreach ($lastTwoSessions as $session) {
            // Check if the student did not attend this session.
            $record = $student->attendanceRecords()
                        ->where('attendance_session_id', $session->id)
                        ->first();
            if (!$record) {
                $missedLastTwo++;
            }
        }
        if ($missedLastTwo >= 2) {
            $alert = true;
        }

        if ($alert) {
            $alerts->push([
                'student' => $student,
                'attended' => $attended,
                'missed' => $missed,
            ]);
        }
    }

    return view('attendance.alerts_course', compact('course', 'alerts'));
}

    /**
     * Archive an attendance alert so it no longer appears.
     */
    public function archiveAlert(Course $course, ClassStudent $student)
    {
        ArchivedAttendanceAlert::updateOrCreate(
            [
                'course_id' => $course->id,
                'class_student_id' => $student->id,
            ],
            ['archived_at' => now()]
        );

        return redirect()->back()->with('status', 'Alert archived');
    }

    /**
     * Show the session management index listing active courses.
     */
    public function sessionsIndex()
    {
        $courses = Course::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        return view('attendance.sessions_index', compact('courses'));
    }

    /**
     * Display sessions for the given course.
     */
    public function sessionsForCourse(Course $course)
    {
        $sessions = $course->attendanceSessions()
            ->orderBy('session_date', 'desc')
            ->get();

        return view('attendance.sessions_course', compact('course', 'sessions'));
    }

    /**
     * Show all students for a specific attendance session with check-in status.
     */
    public function showSession(Course $course, AttendanceSession $session)
    {
        $students = $course->classStudents()->orderBy('last_name')->get();

        $records = AttendanceRecord::where('attendance_session_id', $session->id)
            ->get()
            ->keyBy('class_student_id');

        return view('attendance.session_details', compact('course', 'session', 'students', 'records'));
    }

    /**
     * Toggle attendance for a student for the given session.
     */
    public function toggleAttendance(Course $course, AttendanceSession $session, ClassStudent $student)
    {
        if ($student->class_id !== $course->id) {
            abort(404);
        }

        $record = AttendanceRecord::where('attendance_session_id', $session->id)
            ->where('class_student_id', $student->id)
            ->first();

        if ($record) {
            $record->delete();
            $message = 'Student checked out.';
        } else {
            AttendanceRecord::create([
                'attendance_session_id' => $session->id,
                'class_student_id' => $student->id,
                'check_in_time' => now(),
            ]);
            $message = 'Student checked in.';
        }

        return redirect()->back()->with('status', $message);
    }

    /**
     * Soft delete an attendance session.
     */
    public function archiveSession(Course $course, AttendanceSession $session)
    {
        $session->delete();

        return redirect()->back()->with('status', 'Session archived');
    }

    /**
     * Show attendance reports index page listing active courses.
     */
    public function reportIndex()
    {
        $courses = Course::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        return view('attendance.report_index', compact('courses'));
    }

    /**
     * Display per-student attendance counts for the given course.
     */
    public function reportForCourse(Course $course)
    {
        $totalSessions = $course->attendanceSessions()->count();

        $report = collect();

        foreach ($course->classStudents as $student) {
            $attended = $student->attendanceRecords()
                ->whereHas('attendanceSession', function ($query) use ($course) {
                    $query->where('class_id', $course->id);
                })
                ->count();

            $missed = $totalSessions - $attended;

            $report->push([
                'student' => $student,
                'attended' => $attended,
                'missed' => $missed,
            ]);
        }

        return view('attendance.report_course', compact('course', 'report'));
    }

}

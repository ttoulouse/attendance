<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course; // Make sure Course model maps to the 'classes' table

class CourseController extends Controller
{
    // Show the form to create a course
    public function create()
    {
        return view('courses.create');
    }

    // Process the form submission to store a course
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_title'   => 'required|string|max:255',
            'section_number' => 'required|string|max:50',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
        ]);

        // Create the course
        Course::create($validatedData);

        // Redirect somewhere (e.g., back to dashboard) with a success message
        return redirect()->route('dashboard')->with('status', 'Course created successfully!');
    }

public function all()
    {
        // Use withTrashed() to include soft-deleted courses.
        $courses = Course::withTrashed()->get();
        return view('courses.all', compact('courses'));
    }

    /**
     * Display a list of trashed courses.
     */
    public function trashed()
    {
        $courses = Course::onlyTrashed()->get();
        return view('courses.trashed', compact('courses'));
    }

    /**
     * Restore a soft-deleted course.
     */

    public function destroy(Course $course)
    {
        // This will mark the course as deleted (set deleted_at) without removing it from the database.
        $course->delete();

        return redirect()->route('courses.all')
                         ->with('status', 'Course deleted successfully!');
    }
    public function restore(Request $request, Course $course)
    {
        // Since route model binding won't fetch a trashed model by default,
        // we must use withTrashed() here.
        $course = Course::withTrashed()->findOrFail($course->id);
        $course->restore();
        return redirect()->route('courses.all')
                         ->with('status', 'Course restored successfully!');
    }

public function edit(\App\Models\Course $course)
{
    return view('courses.edit', compact('course'));
}

public function update(Request $request, \App\Models\Course $course)
{
    // Validate the incoming data.
    $validated = $request->validate([
        'course_title'   => 'required|string|max:255',
        'section_number' => 'required|string|max:255',
        'start_date'     => 'required|date',
        'end_date'       => 'required|date|after_or_equal:start_date',
    ]);

    // Update the course record with validated data.
    $course->update($validated);

    // Redirect to a suitable route, for example, your course management page.
    return redirect()->route('courses.all')
                     ->with('status', 'Course updated successfully!');
}

}

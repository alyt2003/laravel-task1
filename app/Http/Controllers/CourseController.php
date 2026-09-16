<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

/**
 * Basic CRUD for courses (the "many" side of the User <-> Course
 * many-to-many relationship — see EnrollmentController for enrollment).
 */
class CourseController extends Controller
{
    /**
     * List all courses.
     */
    public function index()
    {
        return response()->json(Course::all());
    }

    /**
     * Create a course.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = Course::create($validated);

        return response()->json($course, 201);
    }
}

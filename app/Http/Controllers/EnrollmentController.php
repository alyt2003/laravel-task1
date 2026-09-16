<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Demonstrates the Many-to-Many relationship:
 *   User belongsToMany Course / Course belongsToMany User,
 *   through the "course_user" pivot table.
 */
class EnrollmentController extends Controller
{
    /**
     * Enroll the authenticated user in a course.
     *
     * syncWithoutDetaching() adds the pivot row if it's not already there,
     * without touching (and so without accidentally removing) any of the
     * user's other course enrollments.
     */
    public function enroll(Request $request, Course $course)
    {
        $user = $request->user();

        $user->courses()->syncWithoutDetaching([$course->id]);

        return response()->json([
            'message' => 'Enrolled successfully.',
            'courses' => $user->courses()->get(),
        ]);
    }

    /**
     * List a user's enrolled courses.
     */
    public function index(User $user)
    {
        return response()->json($user->courses()->get());
    }

    /**
     * Remove the authenticated user from a course (unenroll).
     *
     * detach() removes just that one pivot row, leaving every other
     * enrollment for this user untouched.
     */
    public function destroy(Request $request, Course $course)
    {
        $user = $request->user();

        $user->courses()->detach($course->id);

        return response()->json([
            'message' => 'Unenrolled successfully.',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * Demonstrates the One-to-One relationship:
 *   User hasOne Profile / Profile belongsTo User.
 */
class ProfileController extends Controller
{
    /**
     * Create/store a profile for the authenticated user, via the
     * relationship: $user->profile()->create($data).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:30',
            'bio' => 'nullable|string',
            'address' => 'nullable|string|max:255',
        ]);

        $user = $request->user();

        if ($user->profile) {
            return response()->json([
                'message' => 'This user already has a profile.',
            ], 409);
        }

        $profile = $user->profile()->create($validated);

        return response()->json($profile, 201);
    }

    /**
     * Show a user's profile, via the relationship: $user->profile.
     */
    public function show(User $user)
    {
        $profile = $user->profile;

        if (! $profile) {
            return response()->json([
                'message' => 'This user does not have a profile yet.',
            ], 404);
        }

        return response()->json($profile);
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Register;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Store a newly created registration from web portal.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'course' => ['required', 'string', 'max:255'],
            'student_name' => ['required', 'string', 'max:150'],
            'father_name' => ['required', 'string', 'max:150'],
            'gender' => ['required', 'string', 'in:Male,Female,Other,male,female,other'],
            'dob' => ['required', 'date', 'before:today'],
            'mobile' => ['required', 'string', 'max:25'],
            'email' => ['required', 'email', 'max:150'],
        ]);

        $validated['gender'] = ucfirst(strtolower($validated['gender']));

        Register::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Registration submitted successfully! Our admissions counselor will contact you shortly.',
            ], 201);
        }

        return back()->with('success', 'Registration submitted successfully! Our admissions counselor will contact you shortly.');
    }
}

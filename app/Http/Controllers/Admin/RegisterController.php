<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Register;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Display a listing of registrations with search, filter, and metrics.
     */
    public function index(Request $request): View
    {
        $query = Register::query();

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('student_name', 'like', "%{$searchTerm}%")
                    ->orWhere('father_name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhere('mobile', 'like', "%{$searchTerm}%")
                    ->orWhere('course', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('course')) {
            $query->where('course', $request->course);
        }

        $registrations = $query->latest()->paginate(50)->withQueryString();

        $stats = [
            'total' => Register::count(),
            'today' => Register::whereDate('created_at', today())->count(),
            'this_month' => Register::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'top_course' => Register::select('course', DB::raw('count(*) as count'))
                ->groupBy('course')
                ->orderByDesc('count')
                ->first()?->course ?? 'None yet',
        ];

        $availableCourses = Register::select('course')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');

        $allStudents = Register::select('id', 'student_name', 'course', 'created_at')
            ->latest()
            ->get();

        return view('admin.screens.register', compact('registrations', 'stats', 'availableCourses', 'allStudents'));
    }

    /**
     * Show printable certificates for one or multiple registered students.
     */
    public function certificate(Request $request, ?Register $register = null): View|RedirectResponse
    {
        if ($request->filled('ids')) {
            $ids = is_array($request->ids) ? $request->ids : explode(',', (string) $request->ids);
            $registrations = Register::whereIn('id', $ids)->get();
        } elseif ($register && $register->exists) {
            $registrations = collect([$register]);
        } else {
            $registrations = Register::latest()->take(1)->get();
        }

        if ($registrations->isEmpty()) {
            return redirect()->route('admin.register.index')
                ->with('error', 'No registered students found for certificate printing.');
        }

        return view('admin.screens.certificate.index', [
            'registrations' => $registrations,
        ]);
    }

    /**
     * Remove the specified registration.
     */
    public function destroy(Register $register): RedirectResponse
    {
        $studentName = $register->student_name;
        $register->delete();

        return redirect()->back()->with('success', "Registration for {$studentName} has been deleted successfully.");
    }

    /**
     * Bulk delete registrations.
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'delIds' => ['required', 'array', 'min:1'],
            'delIds.*' => ['integer', 'exists:registers,id'],
        ]);

        $deletedCount = Register::whereIn('id', $request->delIds)->delete();

        return redirect()->back()->with('success', "{$deletedCount} registration(s) deleted successfully.");
    }
}

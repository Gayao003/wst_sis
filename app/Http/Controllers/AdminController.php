<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $admins = Admin::with('user')->get();
        return view('admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin): View
    {
        return view('admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin): View
    {
        return view('admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'department' => 'required|string',
            'position' => 'required|string',
        ]);

        $admin->update($validated);

        return redirect()->route('admins.show', $admin)
            ->with('success', 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function dashboard()
    {
        $totalStudents = \App\Models\Student::count();
        $totalSubjects = \App\Models\Subject::count();
        $totalEnrollments = \App\Models\Enrollment::count();
        
        // Calculate passing rate
        $totalGrades = \App\Models\Grade::count();
        $passingGrades = \App\Models\Grade::where('total_grade', '<=', 3.00)->count();
        $passingRate = $totalGrades > 0 ? ($passingGrades / $totalGrades) * 100 : 0;
        
        // Get recent enrollments
        $recentEnrollments = \App\Models\Enrollment::with(['student.user', 'subject'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalSubjects',
            'totalEnrollments',
            'passingRate',
            'recentEnrollments'
        ));
    }
}

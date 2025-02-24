<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $enrollments = Enrollment::with(['student.user', 'subject'])->get();
        $students = Student::with('user')->get();
        $subjects = Subject::all();
        return view('admin.enrollments', compact('enrollments', 'students', 'subjects'));
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
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'start_year' => [
                'required',
                'digits:4',
                function ($attribute, $value, $fail) use ($request) {
                    $endYear = $request->input('end_year');
                    if ($value >= $endYear) {
                        $fail('Start year must be less than end year.');
                    }
                }
            ],
            'end_year' => [
                'required',
                'digits:4',
            ],
            'semester' => 'required|in:First,Second,Summer',
        ], [
            'start_year.digits' => 'Please enter a valid year.',
            'end_year.digits' => 'Please enter a valid year.',
        ]);

        // Check for duplicate enrollment
        $exists = Enrollment::where('student_id', $validated['student_id'])
            ->where('subject_id', $validated['subject_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'enrollment' => 'Student is already enrolled in this subject.'
            ])->withInput();
        }

        // Combine the years into the school_year format
        $validated['school_year'] = $validated['start_year'] . '-' . $validated['end_year'];
        
        // Remove the individual year fields
        unset($validated['start_year'], $validated['end_year']);

        Enrollment::create($validated);

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'start_year' => [
                'required',
                'digits:4',
                function ($attribute, $value, $fail) use ($request) {
                    $endYear = $request->input('end_year');
                    if ($value >= $endYear) {
                        $fail('Start year must be less than end year.');
                    }
                }
            ],
            'end_year' => [
                'required',
                'digits:4',
            ],
            'semester' => 'required|in:First,Second,Summer',
        ]);

        // Combine the years into the school_year format
        $validated['school_year'] = $validated['start_year'] . '-' . $validated['end_year'];
        
        // Remove the individual year fields
        unset($validated['start_year'], $validated['end_year']);

        $enrollment->update($validated);

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment deleted successfully');
    }

    public function studentShow(): View
    {
        $enrollments = Enrollment::where('student_id', auth()->user()->student->id)
            ->with(['subject', 'grade'])
            ->get();
        return view('student.enrollments', compact('enrollments'));
    }
}

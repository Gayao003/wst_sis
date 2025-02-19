<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $enrollments = Enrollment::with(['student.user', 'subject', 'grade'])->get();
        return view('admin.grades', compact('enrollments'));
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
            'enrollment_id' => 'required|exists:enrollments,id',
            'midterm' => [
                'required',
                'numeric',
                'min:1.00',
                'max:5.00',
                function ($attribute, $value, $fail) {
                    // Check if the value follows the 0.25 increment pattern
                    $valid = round(($value - 1.00) / 0.25) * 0.25 + 1.00 == $value;
                    if (!$valid) {
                        $fail('The grade must be in increments of 0.25 (e.g., 1.00, 1.25, 1.50, etc.)');
                    }
                }
            ],
            'final' => [
                'required',
                'numeric',
                'min:1.00',
                'max:5.00',
                function ($attribute, $value, $fail) {
                    $valid = round(($value - 1.00) / 0.25) * 0.25 + 1.00 == $value;
                    if (!$valid) {
                        $fail('The grade must be in increments of 0.25 (e.g., 1.00, 1.25, 1.50, etc.)');
                    }
                }
            ],
        ]);

        Grade::create($validated);

        return redirect()->route('admin.grades.index')
            ->with('success', 'Grade created successfully');
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
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'midterm' => [
                'required',
                'numeric',
                'min:1.00',
                'max:5.00',
                function ($attribute, $value, $fail) {
                    // Check if the value follows the 0.25 increment pattern
                    $valid = round(($value - 1.00) / 0.25) * 0.25 + 1.00 == $value;
                    if (!$valid) {
                        $fail('The grade must be in increments of 0.25 (e.g., 1.00, 1.25, 1.50, etc.)');
                    }
                }
            ],
            'final' => [
                'required',
                'numeric',
                'min:1.00',
                'max:5.00',
                function ($attribute, $value, $fail) {
                    $valid = round(($value - 1.00) / 0.25) * 0.25 + 1.00 == $value;
                    if (!$valid) {
                        $fail('The grade must be in increments of 0.25 (e.g., 1.00, 1.25, 1.50, etc.)');
                    }
                }
            ],
        ]);

        // Calculate final grade and remarks
        $grade = ($validated['midterm'] + $validated['final']) / 2;
        $remarks = $this->calculateRemarks($grade);

        $validated['grade'] = $grade;
        $validated['remarks'] = $remarks;

        if ($id === 'new') {
            Grade::create($validated);
        } else {
            $gradeModel = Grade::findOrFail($id);
            $gradeModel->update($validated);
        }

        return redirect()->route('admin.grades.index')
            ->with('success', 'Grade updated successfully');
    }

    private function calculateRemarks($grade): string
    {
        if ($grade <= 3.00) {
            return 'Passed';
        }
        return 'Failed';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function studentIndex(): View
    {
        $enrollments = Enrollment::where('student_id', auth()->user()->student->id)
            ->with(['subject', 'grade'])
            ->get();
        return view('student.grades', compact('enrollments'));
    }
}

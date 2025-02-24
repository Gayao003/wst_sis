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
            'status' => 'required|in:Regular,FDA,LOA,INC',
            'midterm' => [
                'required_if:status,Regular',
                'nullable',
                'numeric',
                'in:1.00,1.25,1.50,1.75,2.00,2.25,2.50,2.75,3.00,5.00'
            ],
            'final' => [
                'required_if:status,Regular',
                'nullable',
                'numeric',
                'in:1.00,1.25,1.50,1.75,2.00,2.25,2.50,2.75,3.00,5.00'
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
            'status' => 'required|in:Regular,FDA,LOA,INC',
            'midterm' => [
                'required_if:status,Regular',
                'nullable',
                'numeric',
                'in:1.00,1.25,1.50,1.75,2.00,2.25,2.50,2.75,3.00,5.00'
            ],
            'final' => [
                'required_if:status,Regular',
                'nullable',
                'numeric',
                'in:1.00,1.25,1.50,1.75,2.00,2.25,2.50,2.75,3.00,5.00'
            ],
        ]);

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

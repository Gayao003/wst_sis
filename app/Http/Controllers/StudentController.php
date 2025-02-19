<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $students = Student::with('user')->get();
        return view('admin.students', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:13',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'course' => 'required|string',
            'year_level' => 'required|integer|min:1|max:5',
            'section' => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'birth_date' => $validated['birth_date'],
                'address' => $validated['address'],
                'role' => 'student',
                'password' => bcrypt('password123'), // Default password
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_id' => 'STU' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'course' => $validated['course'],
                'year_level' => $validated['year_level'],
                'section' => $validated['section'],
            ]);
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        $student->load('user');
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $student->load('user');
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'phone' => 'required|string|max:13',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'course' => 'required|string',
            'year_level' => 'required|integer|min:1|max:5',
            'section' => 'required|string',
        ]);

        DB::transaction(function () use ($validated, $student) {
            // Update User information
            $student->user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'birth_date' => $validated['birth_date'],
                'address' => $validated['address'],
            ]);

            // Update Student information
            $student->update([
                'course' => $validated['course'],
                'year_level' => $validated['year_level'],
                'section' => $validated['section'],
            ]);
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->user->delete(); // This will cascade delete the student record
        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully');
    }
}

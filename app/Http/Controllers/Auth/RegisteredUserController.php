<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:13'],
            'birth_date' => ['required', 'date'],
            'address' => ['required', 'string'],
            'role' => ['required', 'string', 'in:student,admin'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Create corresponding record based on role
        if ($request->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'student_id' => 'STU' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'course' => 'Not Set',
                'year_level' => 1,
                'section' => 'Not Set'
            ]);
        } elseif ($request->role === 'admin') {
            Admin::create([
                'user_id' => $user->id,
                'employee_id' => 'EMP' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'department' => 'Not Set',
                'position' => 'Not Set'
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($request->role === 'student') {
            return redirect()->route('student.dashboard');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }
}

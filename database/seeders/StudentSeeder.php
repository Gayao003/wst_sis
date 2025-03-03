<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Starting student ID number
        $studentIdCounter = 1;
        
        // List of courses
        $courses = ['BSIT', 'BSCS', 'BSIS', 'BSEMC'];
        
        // List of sections
        $sections = ['A', 'B', 'C', 'D'];

        for ($i = 0; $i < 50; $i++) {
            // Generate student ID in format 2201100001
            $studentId = '22011' . str_pad($studentIdCounter, 5, '0', STR_PAD_LEFT);
            
            // Create user account
            $user = User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->numerify('### #### ###'), // Format: XXX XXXX XXX
                'birth_date' => $faker->dateTimeBetween('-22 years', '-17 years')->format('Y-m-d'),
                'role' => 'student',
                'password' => Hash::make('password123'), // Default password for all seeded accounts
            ]);

            // Create student record
            Student::create([
                'user_id' => $user->id,
                'student_id' => $studentId,
                'course' => $faker->randomElement($courses),
                'year_level' => $faker->numberBetween(1, 4),
                'section' => $faker->randomElement($sections),
            ]);

            $studentIdCounter++;
        }
    }
}
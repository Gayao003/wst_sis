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

        for ($i = 0; $i < 50; $i++) {
            $user = User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'birth_date' => $faker->date('Y-m-d', '-18 years'),
                'address' => $faker->address(),
                'role' => 'student',
                'password' => Hash::make('password123'),
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_id' => 'STU' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'course' => $faker->randomElement(['BSIT', 'BSCS', 'BSIS', 'BSEMC']),
                'year_level' => $faker->numberBetween(1, 4),
                'section' => $faker->randomElement(['A', 'B', 'C', 'D']),
            ]);
        }
    }
}

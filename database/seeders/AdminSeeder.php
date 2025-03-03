<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'phone' => null,
            'birth_date' => '1990-01-01',
            'role' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        Admin::create([
            'user_id' => $user->id,
            'employee_id' => 'ADM001',
            'department' => 'Information Technology',
            'position' => 'System Administrator'
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [];

        for ($i = 1; $i <= 25; $i++) {

            $students[] = [
                'full_name' => 'Student ' . $i,
                'father_name' => 'Father ' . $i,
                'email' => 'student' . $i . '@gmail.com',
                'aadhar_number' => '100000000' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'mobile_number' => '987654' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'address' => 'Indore, Madhya Pradesh',
                'image' => null,
                'joining_date' => now()->subDays($i),
                'status' => $i % 5 === 0 ? 'inactive' : 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Student::insert($students);
    }
}
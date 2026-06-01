<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certification;
use App\Models\User;
use App\Models\Center;
use App\Models\Customer;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Students
        $students = Customer::where('role', 'student')->get();

        // Results Array
        $results = [
            'Outstanding',
            'Excellent',
            'Very Good',
            'Pass'
        ];

        // Levels
        $levels = [
            'Junior',
            'Level 1',
            'Level 2',
            'Level 3',
            'Level 4',
            'Level 5'
        ];

        foreach ($students as $student) {

            // Get Student Center
            $center = Center::find($student->center_id);

            // Random Score
            $score = rand(70, 100);

            // Result Logic
            $result = match (true) {
                $score >= 95 => 'Outstanding',
                $score >= 90 => 'Excellent',
                $score >= 80 => 'Very Good',
                default      => 'Pass',
            };

            Certification::create([

                // Trainer Details
                'trainer_name' => $center->assigned_teacher_name ?? 'Avinash',

                // Certificate Info
                'certificate_date' => now()->subDays(rand(1, 60)),
                'level' => $levels[array_rand($levels)],

                // Student Info
                'student_name' => $student->name,
                'parents_name' => 'Parent of ' . $student->name,
                'mobile_no' => $student->mobile,
                'exam_date' => now()->subDays(rand(10, 90)),

                // Marks
                'score' => $score,
                'result' => $result,

                // Address
                'address' => $student->address
                    ?? ($student->city . ', ' . $student->state),

                'receiver_contact' => $student->mobile,

                // Images
                'address_image' => null,
                'certificate_image' => null,

                // Dispatch
                'dispatch_date' => now()->subDays(rand(1, 10)),
                'dispatch_id' => 'TRK' . rand(100000, 999999),

                // Receive
                'received_date' => now(),
                'remark' => 'Certificate delivered successfully.',

                // Download
                'download_type' => 'PDF',

                // Timestamps
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questions')->insert([

            [
                'question' => '+45+23-12',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '56',
                    'B' => '66',
                    'C' => '76',
                    'D' => '46',
                ]),
                'correct_option' => 'A',
                'exam_level' => 1,
                'difficulty' => 'easy',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'question' => '-100+250-50',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '150',
                    'B' => '100',
                    'C' => '200',
                    'D' => '300',
                ]),
                'correct_option' => 'A',
                'exam_level' => 1,
                'difficulty' => 'easy',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'question' => '+500-200+100',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '350',
                    'B' => '400',
                    'C' => '450',
                    'D' => '300',
                ]),
                'correct_option' => 'B',
                'exam_level' => 2,
                'difficulty' => 'medium',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'question' => '+77+88-55',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '100',
                    'B' => '120',
                    'C' => '110',
                    'D' => '90',
                ]),
                'correct_option' => 'C',
                'exam_level' => 2,
                'difficulty' => 'easy',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'question' => '-345+678-123',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '210',
                    'B' => '220',
                    'C' => '230',
                    'D' => '240',
                ]),
                'correct_option' => 'A',
                'exam_level' => 3,
                'difficulty' => 'medium',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'question' => '+999-444+111',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '555',
                    'B' => '666',
                    'C' => '777',
                    'D' => '888',
                ]),
                'correct_option' => 'B',
                'exam_level' => 3,
                'difficulty' => 'medium',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'question' => '+123+321-111',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '333',
                    'B' => '343',
                    'C' => '353',
                    'D' => '363',
                ]),
                'correct_option' => 'A',
                'exam_level' => 4,
                'difficulty' => 'easy',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'question' => '-500+1000-250',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '200',
                    'B' => '250',
                    'C' => '300',
                    'D' => '350',
                ]),
                'correct_option' => 'B',
                'exam_level' => 4,
                'difficulty' => 'hard',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'question' => '+654-321+123',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '446',
                    'B' => '456',
                    'C' => '466',
                    'D' => '476',
                ]),
                'correct_option' => 'B',
                'exam_level' => 5,
                'difficulty' => 'medium',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'question' => '+1000-999+888',
                'question_type_id' => 1,
                'options' => json_encode([
                    'A' => '888',
                    'B' => '889',
                    'C' => '890',
                    'D' => '891',
                ]),
                'correct_option' => 'B',
                'exam_level' => 5,
                'difficulty' => 'hard',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
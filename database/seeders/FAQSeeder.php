<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('faqs')->insert([
            [
                'question' => 'What services do you provide?',
                'answer' => 'We provide complete support services for NRIs including property management, documentation, and local assistance.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'How can I contact support?',
                'answer' => 'You can contact our support team through phone, email, or WhatsApp.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Do you offer property management services?',
                'answer' => 'Yes, we offer end-to-end property management solutions for NRIs.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Can I track my service request?',
                'answer' => 'Yes, you can track your request status through our portal.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Do you provide legal documentation help?',
                'answer' => 'Yes, we assist with various legal and government documentation processes.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'What are your working hours?',
                'answer' => 'Our support team is available Monday to Saturday from 9 AM to 7 PM.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'How do I book a consultation?',
                'answer' => 'You can book a consultation directly through our website contact form.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Do you offer emergency support?',
                'answer' => 'Yes, emergency assistance is available for selected services.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Can I update my personal details later?',
                'answer' => 'Yes, you can update your profile and personal information anytime.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Are your services available across India?',
                'answer' => 'Yes, we provide services in multiple cities across India.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
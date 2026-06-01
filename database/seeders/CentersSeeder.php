<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('centers')->insert([

            [
                'country_name' => 'India',
                'state_name' => 'Maharashtra',
                'district_name' => 'Mumbai',
                'center_name' => 'Mumbai Abacus Academy',
                'center_address' => 'Andheri East, Mumbai, Maharashtra',
                'center_contact' => '+91 9876543210',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'Senior International Trainer',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'country_name' => 'India',
                'state_name' => 'Karnataka',
                'district_name' => 'Bangalore Urban',
                'center_name' => 'Bangalore Smart Kids Center',
                'center_address' => 'Whitefield, Bengaluru, Karnataka',
                'center_contact' => '+91 9876500011',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'Expert Abacus Faculty',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'country_name' => 'India',
                'state_name' => 'Tamil Nadu',
                'district_name' => 'Chennai',
                'center_name' => 'Chennai Brain Academy',
                'center_address' => 'Anna Nagar, Chennai, Tamil Nadu',
                'center_contact' => '+91 9876500022',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'Child Development Specialist',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'country_name' => 'India',
                'state_name' => 'Telangana',
                'district_name' => 'Hyderabad',
                'center_name' => 'Hyderabad Abacus Hub',
                'center_address' => 'Madhapur, Hyderabad, Telangana',
                'center_contact' => '+91 9876500033',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'Mathematics Skill Trainer',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'country_name' => 'India',
                'state_name' => 'West Bengal',
                'district_name' => 'Kolkata',
                'center_name' => 'Kolkata Learning Center',
                'center_address' => 'Salt Lake, Kolkata, West Bengal',
                'center_contact' => '+91 9876500044',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'Mental Math Expert',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'country_name' => 'India',
                'state_name' => 'Gujarat',
                'district_name' => 'Ahmedabad',
                'center_name' => 'Ahmedabad Kids Academy',
                'center_address' => 'Navrangpura, Ahmedabad, Gujarat',
                'center_contact' => '+91 9876500055',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'Abacus and Vedic Maths Trainer',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'country_name' => 'India',
                'state_name' => 'Rajasthan',
                'district_name' => 'Jaipur',
                'center_name' => 'Jaipur Education Center',
                'center_address' => 'Vaishali Nagar, Jaipur, Rajasthan',
                'center_contact' => '+91 9876500066',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'Brain Development Coach',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'country_name' => 'India',
                'state_name' => 'Punjab',
                'district_name' => 'Ludhiana',
                'center_name' => 'Punjab Abacus Institute',
                'center_address' => 'Model Town, Ludhiana, Punjab',
                'center_contact' => '+91 9876500077',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'Certified Abacus Trainer',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'country_name' => 'India',
                'state_name' => 'Uttar Pradesh',
                'district_name' => 'Lucknow',
                'center_name' => 'Lucknow Smart Learning',
                'center_address' => 'Gomti Nagar, Lucknow, Uttar Pradesh',
                'center_contact' => '+91 9876500088',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'Mental Arithmetic Specialist',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'country_name' => 'India',
                'state_name' => 'Kerala',
                'district_name' => 'Kochi',
                'center_name' => 'Kochi Abacus World',
                'center_address' => 'Edappally, Kochi, Kerala',
                'center_contact' => '+91 9876500099',
                'assigned_teacher_id' => 2,
                'assigned_teacher_name' => 'Avinash',
                'assigned_teacher_about' => 'International Faculty Trainer',
                'created_at' => $now,
                'updated_at' => $now,
            ],

        ]);
    }
}
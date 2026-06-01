<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([

            [
                'name' => 'Rahul Sharma',
                'profile' => '',
                'slug_id' => 'rahul-sharma',
                'email' => 'rahulsharma@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Priya Verma',
                'profile' => '',
                'slug_id' => 'priya-verma',
                'email' => 'priyaverma@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Amit Patil',
                'profile' => '',
                'slug_id' => 'amit-patil',
                'email' => 'amitpatil@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Sneha Kulkarni',
                'profile' => '',
                'slug_id' => 'sneha-kulkarni',
                'email' => 'snehakulkarni@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Vikas Gupta',
                'profile' => '',
                'slug_id' => 'vikas-gupta',
                'email' => 'vikasgupta@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Neha Joshi',
                'profile' => '',
                'slug_id' => 'neha-joshi',
                'email' => 'nehajoshi@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Rohan Mehta',
                'profile' => '',
                'slug_id' => 'rohan-mehta',
                'email' => 'rohanmehta@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Anjali Desai',
                'profile' => '',
                'slug_id' => 'anjali-desai',
                'email' => 'anjalidesai@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Karan Singh',
                'profile' => '',
                'slug_id' => 'karan-singh',
                'email' => 'karansingh@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Pooja Nair',
                'profile' => '',
                'slug_id' => 'pooja-nair',
                'email' => 'poojanair@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'type' => 0,
                'permissions' => '',
                'status' => 1,
                'fcm_id' => null,
                'remember_token' => null,
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
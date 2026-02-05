<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        // Admin
        User::create([
            'first_name' => env('SEEDER_USER_FIRST_NAME', 'John'),
            'last_name' => env('SEEDER_USER_LAST_NAME', 'Publ'),
            'username' => env('SEEDER_USER_USERNAME', 'admin'),
            'password' => bcrypt((env('SEEDER_USER_PASSWORD', '123456'))),
            'email' => 'admin@publsoft.com',
            'phone_number' => '901234567890',
            'is_admin' => true,
        ]);

        // Agent
        User::create([
            'first_name' => 'Istanbul',
            'last_name' => 'Agent',
            'username' => 'agent',
            'password' => bcrypt('123456'),
            'email' => 'agent@publsoft.com',
            'phone_number' => '901234567890',
            'is_agent' => true,
        ]);
    }
}
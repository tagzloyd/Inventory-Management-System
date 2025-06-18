<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'create@carsu.edu.ph'],
            [
                'first_name' => 'CReaATE',
                'last_name' => 'Admin',
                'password' => Hash::make('Create-admin'),
                'role' => 'admin'
            ]
        );
    }
}

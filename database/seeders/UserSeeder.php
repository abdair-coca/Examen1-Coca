<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5 usuarios random
        User::factory(5)->create();

        // Usuario admin fijo
        User::firstOrCreate(
            ['email' => 'admin@uatf.bo'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );
    }
}

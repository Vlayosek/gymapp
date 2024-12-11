<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $userAdmin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@me.com',
            'password' => bcrypt('qazokmwsxijn1928384756'),
        ]);

        $userDefault = User::create([
            'name' => 'User',
            'email' => 'user@me.com',
            'password' => bcrypt('passw0rd'),
        ]);

        $userAdmin->assignRole('admin');
        $userDefault->assignRole('standard');
    }
}

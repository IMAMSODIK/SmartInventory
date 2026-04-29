<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'password' => bcrypt('12345'),
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'status' => 1
        ]);

        User::create([
            'name' => 'pedagang 1',
            'password' => bcrypt('12345'),
            'email' => 'pedagang@gmail.com',
            'role' => 'pedagang'
        ]);

        User::create([
            'name' => 'pedagang 2',
            'password' => bcrypt('12345'),
            'email' => 'pedagang2@gmail.com',
            'role' => 'pedagang'
        ]);

        $this->call([
            KategoriSeeder::class,
        ]);
    }
}

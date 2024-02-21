<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BusTableSeeder::class);
        $this->call(SupirTableSeeder::class);
        $this->call(TerminalTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}

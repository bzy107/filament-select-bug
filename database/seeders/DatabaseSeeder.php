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
        $this->call(
            [
                UserSeeder::class,
                OwnerSeeder::class,
                PatientSeeder::class,
                TreatmentSeeder::class,
                ItemSeeder::class,
                OrderSeeder::class,
                // ItemOrderSeeder::class,
            ]
        );
    }
}

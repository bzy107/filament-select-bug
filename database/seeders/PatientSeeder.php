<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Owner::all() as $owner) {
            Patient::factory()->create([
                'owner_id' => $owner->id,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Treatment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Patient::all() as $patient) {
            Treatment::factory()->create([
                'patient_id' => $patient->id,
            ]);
        }
    }
}

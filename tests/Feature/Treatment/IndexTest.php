<?php

use App\Filament\Resources\TreatmentResource;
use App\Models\Treatment;
use function Pest\Livewire\livewire;

test('表示されること', function () {
    Treatment::factory(10)->create();
    livewire(TreatmentResource\Pages\ListTreatments::class)
        ->assertSuccessful();
});

// test('フィルタ', function () {
//     $treatment = Treatment::factory()->create();
//     $otherTreatment = Treatment::factory()->create();

//     $treatments = Treatment::all();

//     livewire(TreatmentResource\Pages\ListTreatments::class)
//         ->assertCanSeeTableRecords($treatments)
//         ->filterTable('description', $treatment->description);
//         // ->assertCanSeeTableRecords($treatment)
//         // ->assertCanNotSeeTableRecords($otherTreatment);
// });

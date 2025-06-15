<?php

namespace App\Filament\Resources\CustomTreatmentResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\CustomTreatmentResource;
use App\Filament\Trait\CommonTab;
use App\Models\Treatment;
use Closure;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCustomTreatments extends ListRecords
{
    protected static string $resource = CustomTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    use CommonTab;

    public function getTabQuery(?Treatment $treatment): Closure
    {
        return fn (Builder $query) => $query->where('patients.id', $treatment->patient_id);
    }
}

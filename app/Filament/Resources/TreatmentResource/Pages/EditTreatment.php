<?php

namespace App\Filament\Resources\TreatmentResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\TreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTreatment extends EditRecord
{
    protected static string $resource = TreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

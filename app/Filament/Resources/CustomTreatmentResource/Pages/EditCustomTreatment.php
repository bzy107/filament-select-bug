<?php

namespace App\Filament\Resources\CustomTreatmentResource\Pages;

use App\Filament\Resources\CustomTreatmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomTreatment extends EditRecord
{
    protected static string $resource = CustomTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

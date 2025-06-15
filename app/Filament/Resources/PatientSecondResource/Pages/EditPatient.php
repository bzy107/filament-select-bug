<?php

namespace App\Filament\Resources\PatientSecondResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\PatientSecondResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientSecondResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

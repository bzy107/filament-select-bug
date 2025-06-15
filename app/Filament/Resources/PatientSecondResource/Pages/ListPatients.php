<?php

namespace App\Filament\Resources\PatientSecondResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\PatientSecondResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientSecondResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

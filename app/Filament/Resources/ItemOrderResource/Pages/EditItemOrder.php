<?php

namespace App\Filament\Resources\ItemOrderResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\ItemOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemOrder extends EditRecord
{
    protected static string $resource = ItemOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

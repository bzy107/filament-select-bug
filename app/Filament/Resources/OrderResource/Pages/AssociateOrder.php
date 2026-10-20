<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class AssociateOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'Associate Items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('items')
                    ->relationship('items', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

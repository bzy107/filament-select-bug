<?php

namespace App\Filament\Resources\PatientSecondResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TreatmentSecondsRelationManager extends RelationManager
{
    protected static string $relationship = 'treatments';

    public function form(Form $schema): Form
    {
        return $schema
            ->schema([
                TextInput::make('id')
                    ->disabled(),
                Section::make()
                    ->schema([
                        TextInput::make('description')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan('full'),
                        Textarea::make('notes')
                            ->maxLength(65535)
                            ->columnSpan('full'),
                        ToggleButtons::make('has_prescription')
                            ->required()
                            ->boolean()
                            ->options([
                                0 => 'no',
                                1 => 'yes',
                            ])
                            ->inline()
                            ->grouped(),
                        TextInput::make('price')
                            ->integer()
                            ->prefix('€')
                            ->maxValue(42949672.95),
                    ]),
                Section::make()
                    ->schema([
                        TextInput::make('created_at')
                            ->disabled(),
                        TextInput::make('updated_at')
                            ->disabled(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('description'),
                TextColumn::make('price')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime(),
                IconColumn::make('has_prescription')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

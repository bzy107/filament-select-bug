<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TreatmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'treatments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('aiu')
                    ->disabled(),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('description')
                            ->label('aiu')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan('full'),
                        Forms\Components\Textarea::make('notes')
                            ->label('aiu')
                            ->maxLength(65535)
                            ->columnSpan('full'),
                        Forms\Components\ToggleButtons::make('has_prescription')
                            ->label('aiu')
                            ->required()
                            ->boolean()
                            ->options([
                                0 => 'いいえ',
                                1 => 'はい',
                            ])
                            ->inline()
                            ->grouped(),
                        Forms\Components\TextInput::make('price')
                            ->label('aiu')
                            ->integer()
                            ->prefix('€')
                            ->maxValue(42949672.95),
                    ]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('created_at')
                            ->label('aiu')
                            ->disabled(),
                        Forms\Components\TextInput::make('updated_at')
                            ->label('aiu')
                            ->disabled(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('price')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\IconColumn::make('has_prescription')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

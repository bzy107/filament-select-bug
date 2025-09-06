<?php

namespace App\Filament\Resources\TreatmentResource\RelationManagers;

use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class PatientRelationManager extends RelationManager
{
    protected static string $relationship = 'patient';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->disabled()
                    ->hidden(fn (string $operation) => $operation === 'create'),
                Section::make()
                    ->schema([
                        DatePicker::make('date_of_birth')
                            ->required(),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('type')
                            ->required()
                            ->maxLength(255),
                        Select::make('owner_id')
                            ->relationship('owner', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),
                        ToggleButtons::make('has_recovered')
                            ->required()
                            ->boolean()
                            ->inline()
                            ->grouped(),
                    ])
                    ->columns(2),
                Section::make()
                    ->schema([
                        TextInput::make('created_at')
                            ->disabled(),
                        TextInput::make('updated_at')
                            ->disabled(),
                    ])
                    ->hidden(fn (string $operation) => $operation === 'create')
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('owner.name')
                    ->label('owner name')
                    ->searchable(),
                IconColumn::make('has_recovered')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->hidden(fn ($livewire) => $livewire->getOwnerRecord()?->patient),
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

<?php

namespace App\Filament\Resources\TreatmentResource\RelationManagers;

use App\Models\Owner;
use Filament\Forms;
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
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                // Select::make('owner_id')
                //     ->relationship('owner', 'name')
                //     ->searchable()
                //     ->preload()
                //     ->live(),
                Select::make('owner_name')
                    ->label('owner name')
                    // ->relationship('owner', 'name')
                    ->options(
                        function () {
                            // return Owner::whereNotNull('name')
                            //     ->orderBy('name')
                            //     ->pluck('name', 'id')
                            //     ->toArray();
                            // return Owner::select('name', 'id')->orderBy('name')->pluck('name', 'id')->toArray();
                            return Owner::select(
                                DB::raw('name as name1'),
                                DB::raw('name as name2')
                            )
                                ->orderBy('name')
                                ->pluck('name1', 'name2')
                                ->toArray();
                        }
                    )
                    ->searchable()
                    ->preload()
                    ->live(),
                ToggleButtons::make('has_recovered')
                    ->required()
                    ->boolean()
                    ->inline()
                    ->grouped(),
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

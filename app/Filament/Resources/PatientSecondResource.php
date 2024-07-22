<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PatientExporter;
use App\Filament\Imports\PatientImporter;
use App\Filament\Resources\PatientSecondResource\Pages;
use App\Filament\Resources\PatientSecondResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PatientSecondResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return 'PatientSecond';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->disabled(),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\ToggleButtons::make('has_recovered')
                    ->required()
                    ->boolean()
                    ->inline()
                    ->grouped(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('has_recovered')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->importer(PatientImporter::class),
                Tables\Actions\ExportAction::make()
                    ->exporter(PatientExporter::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportBulkAction::make()
                        ->exporter(PatientExporter::class),
                ]),
            ])
            ->selectCurrentPageOnly();
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TreatmentSecondsRelationManager::class,
            RelationManagers\TreatmentThirdsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}

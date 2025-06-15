<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\ImportAction;
use Filament\Actions\ExportAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportBulkAction;
use App\Filament\Resources\PatientSecondResource\RelationManagers\TreatmentSecondsRelationManager;
use App\Filament\Resources\PatientSecondResource\RelationManagers\TreatmentThirdsRelationManager;
use App\Filament\Resources\PatientSecondResource\Pages\ListPatients;
use App\Filament\Resources\PatientSecondResource\Pages\CreatePatient;
use App\Filament\Resources\PatientSecondResource\Pages\EditPatient;
use App\Filament\Exports\PatientExporter;
use App\Filament\Imports\PatientImporter;
use App\Filament\Resources\PatientSecondResource\Pages;
use App\Filament\Resources\PatientSecondResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PatientSecondResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return 'PatientSecond';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->disabled(),
                DatePicker::make('date_of_birth')
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                ToggleButtons::make('has_recovered')
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
                IconColumn::make('has_recovered')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('has_recovered')
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(PatientImporter::class),
                ExportAction::make()
                    ->exporter(PatientExporter::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(PatientExporter::class),
                ]),
            ])
            ->selectCurrentPageOnly();
    }

    public static function getRelations(): array
    {
        return [
            TreatmentSecondsRelationManager::class,
            TreatmentThirdsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPatients::route('/'),
            'create' => CreatePatient::route('/create'),
            'edit' => EditPatient::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Exports\TreatmentExporter;
use App\Filament\Resources\TreatmentResource\Pages;
use App\Filament\Resources\TreatmentResource\Pages\CreateTreatment;
use App\Filament\Resources\TreatmentResource\Pages\EditTreatment;
use App\Filament\Resources\TreatmentResource\Pages\ListTreatments;
use App\Filament\Resources\TreatmentResource\RelationManagers;
use App\Filament\Resources\TreatmentResource\RelationManagers\PatientRelationManager;
use App\Models\Treatment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $schema): Form
    {
        return $schema
            ->schema([
                Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('description')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
                ToggleButtons::make('has_prescription')
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
                TextColumn::make('patient.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('notes')
                    ->searchable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                IconColumn::make('has_prescription')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters(
                [
                    QueryBuilder::make()
                        ->constraints(
                            [
                                TextConstraint::make('description')
                                    ->label('description'),
                                TextConstraint::make('notes')
                                    ->label('notes'),
                                NumberConstraint::make('price')
                                    ->label('price'),
                            ]
                        )
                        ->constraintPickerColumns(3),
                    ],
                    layout: FiltersLayout::AboveContentCollapsible
            )
            ->headerActions([
                ExportAction::make()
                    ->exporter(TreatmentExporter::class),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(TreatmentExporter::class),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PatientRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTreatments::route('/'),
            'create' => CreateTreatment::route('/create'),
            'edit' => EditTreatment::route('/{record}/edit'),
        ];
    }
}

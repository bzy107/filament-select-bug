<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Actions\ExportAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportBulkAction;
use App\Filament\Resources\TreatmentResource\Pages\ListTreatments;
use App\Filament\Resources\TreatmentResource\Pages\CreateTreatment;
use App\Filament\Resources\TreatmentResource\Pages\EditTreatment;
use App\Filament\Exports\TreatmentExporter;
use App\Filament\Resources\TreatmentResource\Pages;
use App\Filament\Resources\TreatmentResource\RelationManagers;
use App\Models\Treatment;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->preload()
                    ->required(),
                TextInput::make('description')
                    ->required()
                    ->maxLength(255),
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
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
            //
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

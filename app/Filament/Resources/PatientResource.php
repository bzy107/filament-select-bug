<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PatientExporter;
use App\Filament\Imports\PatientImporter;
use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\Pages\CreatePatient;
use App\Filament\Resources\PatientResource\Pages\EditPatient;
use App\Filament\Resources\PatientResource\Pages\ListPatients;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Filament\Resources\PatientResource\RelationManagers\TreatmentsRelationManager;
use App\Models\Owner;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $schema): Form
    {
        return $schema
            ->schema([
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
                Select::make('owner_id')
                    ->label('owner name')
                    // ->relationship('owner', 'name')
                    ->options(
                        function () {
                            // return Owner::whereNotNull('name')
                            //     ->orderBy('phone')
                            //     ->pluck('name', 'id')
                            //     ->toArray();
                            // return Owner::select(
                            //     DB::raw('phone'),
                            //     DB::raw('id')
                            // )
                            //     ->orderBy('name')
                            //     ->pluck('name', 'id')
                            //     ->toArray();
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
                TextColumn::make('owner.name')
                    ->label('owner name')
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
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('name'),
                        TextConstraint::make('type'),
                        BooleanConstraint::make('has_recovered'),
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->headerActions([
                ImportAction::make()
                    ->importer(PatientImporter::class),
                ExportAction::make()
                    ->exporter(PatientExporter::class),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
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
            TreatmentsRelationManager::class,
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

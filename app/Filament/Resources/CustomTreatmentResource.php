<?php

namespace App\Filament\Resources;

use App\Filament\Exports\TreatmentExporter;
use App\Filament\Resources\CustomTreatmentResource\Pages\CreateCustomTreatment;
use App\Filament\Resources\CustomTreatmentResource\Pages\EditCustomTreatment;
use App\Filament\Resources\CustomTreatmentResource\Pages\ListCustomTreatments;
use App\Models\Treatment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as DatabaseQueryBuilder;

class CustomTreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    public static function getNavigationLabel(): string
    {
        return __('CustomTreatmentResource');
    }

    public static function getModelLabel(): string
    {
        return __('CustomTreatmentResource');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $schema): Form
    {
        return $schema
            ->schema([
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
            ->modifyQueryUsing(
                function (Builder $query) {
                    $query->select(
                        'sub.id',
                        'sub.description',
                        'sub.name',
                        'sub.type',
                    )
                        ->fromSub(
                            function (DatabaseQueryBuilder $query) {
                                $query->select(
                                    't.id',
                                    't.description',
                                    'p.name',
                                    'p.type'
                                )
                                    ->from('treatments', 't')
                                    ->join('patients as p', 't.patient_id', '=', 'p.id')
                                    ->where('t.is_valid', 1);
                            },
                            'sub'
                        )
                        ->withTrashed();
                }
            )
            ->columns([
                TextColumn::make('id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
            ])
            ->defaultSort(
                column: fn (Builder $query) => $query->orderBy('sub.name', 'asc')
            )
            ->filters(
                [
                    QueryBuilder::make()
                        ->constraints(
                            [
                                TextConstraint::make('description')
                                    ->label('description'),
                                TextConstraint::make('name')
                                    ->label('name'),
                                NumberConstraint::make('type')
                                    ->label('type'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomTreatments::route('/'),
            'create' => CreateCustomTreatment::route('/create'),
            'edit' => EditCustomTreatment::route('/{record}/edit'),
        ];
    }
}

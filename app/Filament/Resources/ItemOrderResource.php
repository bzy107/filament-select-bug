<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ItemOrderExporter;
use App\Filament\Resources\ItemOrderResource\Pages;
use App\Filament\Resources\ItemOrderResource\RelationManagers;
use App\Models\ItemOrder;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemOrderResource extends Resource
{
    protected static ?string $model = ItemOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.id')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()
                    ->exporter(ItemOrderExporter::class)
                    ->formats([
                        ExportFormat::Csv
                    ])
                    ->chunkSize(2),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListItemOrders::route('/'),
        ];
    }
}

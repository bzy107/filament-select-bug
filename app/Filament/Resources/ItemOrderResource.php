<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ExportAction;
use Filament\Actions\EditAction;
use App\Filament\Resources\ItemOrderResource\Pages\ListItemOrders;
use App\Filament\Resources\ItemOrderResource\Pages\EditItemOrder;
use App\Filament\Exports\ItemOrderExporter;
use App\Filament\Resources\ItemOrderResource\Pages;
use App\Filament\Resources\ItemOrderResource\RelationManagers;
use App\Models\ItemOrder;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemOrderResource extends Resource
{
    protected static ?string $model = ItemOrder::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('item.id')
                    ->disabled(),
                TextInput::make('order.id')
                    ->disabled(),
                TextInput::make('memo')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('order.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('memo')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(ItemOrderExporter::class)
                    ->formats([
                        ExportFormat::Csv
                    ])
                    ->chunkSize(2),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
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
            'index' => ListItemOrders::route('/'),
            'edit' => EditItemOrder::route('/{record}/edit'),
        ];
    }
}

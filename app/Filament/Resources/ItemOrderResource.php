<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ItemOrderExporter;
use App\Filament\Resources\ItemOrderResource\Pages\EditItemOrder;
use App\Filament\Resources\ItemOrderResource\Pages\ListItemOrders;
use App\Models\ItemOrder;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemOrderResource extends Resource
{
    protected static ?string $model = ItemOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $schema): Form
    {
        return $schema
            ->schema([
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
                        ExportFormat::Csv,
                    ])
                    ->chunkSize(2),
            ])
            ->actions([
                EditAction::make(),
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
            'index' => ListItemOrders::route('/'),
            'edit' => EditItemOrder::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\ItemResource\Pages\ListItems;
use App\Filament\Resources\ItemResource\Pages\CreateItem;
use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers\OrderRelationManager;
use App\Models\Item;
use Filament\Forms;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('name')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->limit(10)
                    ->sortable(),
                TextColumn::make('price')
                    ->money()
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
                        NumberConstraint::make('price'),
                    ]),
                ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('price'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ])
            ->columns(1)
            ->inlineLabel();
    }

    public static function getRelations(): array
    {
        return [
            OrderRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItems::route('/'),
            'create' => CreateItem::route('/create'),
            // 'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}

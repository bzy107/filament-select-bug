<?php

namespace App\Filament\Exports;

use App\Models\ItemOrder;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ItemOrderExporter extends Exporter
{
    protected static ?string $model = ItemOrder::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('item_id'),
            ExportColumn::make('order_id'),
            ExportColumn::make('memo'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your item order export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

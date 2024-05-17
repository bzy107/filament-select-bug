<?php

namespace App\Filament\Exports;

use App\Models\Patient;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PatientExporter extends Exporter
{
    protected static ?string $model = Patient::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('date_of_birth')
                ->label('DATA_OF_BIRTH'),
            ExportColumn::make('name')
                ->label('NAME'),
            ExportColumn::make('type')
                ->label('TYPE'),
            ExportColumn::make('has_recovered')
                ->label('HAS_RECOVERED'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your patient export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

<?php

namespace App\Filament\Exports;

use App\Models\Treatment;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Exports\Enums\ExportFormat;

class TreatmentExporter extends Exporter
{
    protected static ?string $model = Treatment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('description')
                ->label('DESCRIPTION'),
            ExportColumn::make('notes')
                ->label('NOTES'),
            ExportColumn::make('patient_id')
                ->label('PATIENT_ID'),
            ExportColumn::make('price')
                ->label('PRICE'),
            ExportColumn::make('has_prescription')
                ->label('HAS_PRESCRIPTION'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your treatment export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFormats(): array
    {
        return [
            ExportFormat::Csv,
        ];
    }
}

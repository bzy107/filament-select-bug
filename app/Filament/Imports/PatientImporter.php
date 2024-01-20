<?php

namespace App\Filament\Imports;

use App\Models\Patient;
use Carbon\CarbonInterface;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Validation\Rule;

class PatientImporter extends Importer
{
    protected static ?string $model = Patient::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->rules(
                    [
                        'nullable',
                        'integer',
                        'exists:App\Models\Patient',
                    ]
                ),
            ImportColumn::make('date_of_birth')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(
                    fn ($record) =>
                    [
                        'required',
                        'max:255',
                        Rule::unique(Patient::class)
                            ->ignore($record->id),
                    ]
                ),
            ImportColumn::make('type')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Patient
    {
        return Patient::firstOrNew([
            'id' => $this->data['id'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your patient import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    public function getJobRetryUntil(): ?CarbonInterface
    {
        return null;
    }
}

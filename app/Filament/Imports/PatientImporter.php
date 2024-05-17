<?php

namespace App\Filament\Imports;

use App\Models\Patient;
use Carbon\CarbonInterface;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PatientImporter extends Importer
{
    protected static ?string $model = Patient::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->label('ID')
                ->exampleHeader('ID')
                ->rules(
                    [
                        'nullable',
                        'integer',
                        Rule::exists(Patient::class, 'id')
                            ->whereNull('deleted_at'),
                    ]
                ),
            ImportColumn::make('date_of_birth')
                ->label('DATA_OF_BIRTH')
                ->exampleHeader('DATA_OF_BIRTH')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('name')
                ->label('NAME')
                ->exampleHeader('NAME')
                ->requiredMapping()
                ->rules(
                    fn ($record) => [
                        'required',
                        'max:255',
                        Rule::unique(Patient::class)
                            ->whereNull('deleted_at')
                            ->ignore($record->id),
                    ]
                ),
            ImportColumn::make('type')
                ->label('TYPE')
                ->exampleHeader('TYPE')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('has_recovered')
                ->label('HAS_RECOVERED')
                ->exampleHeader('HAS_RECOVERED')
                ->requiredMapping()
                ->rules(['required', 'boolean'])
                ->castStateUsing(function ($state) {
                    if ($state === 'true' || $state === 'false') {
                        return $state === 'true';
                    }

                    return 'string';
                }),
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

    public function beforeSave(): void
    {
        Validator::make(
            $this->data,
            [
                'name.unique' => [
                    Rule::unique(Patient::class)
                        ->ignore($this->data['id']),
                ],
            ]
        )
            ->validate();
    }
}

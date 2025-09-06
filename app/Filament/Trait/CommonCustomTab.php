<?php

namespace App\Filament\Trait;

use App\Models\Treatment;
use Closure;
use Filament\Resources\Concerns\HasTabs;
use Filament\Schemas\Components\Tabs\Tab;

trait CommonCustomTab
{
    use HasTabs;

    public function getTabs(): array
    {
        $tab = [];
        $tab['すべて'] = Tab::make();

        foreach (Treatment::all() as $treatment) {
            $tab[$treatment->patient->name] = Tab::make($treatment->patient->name)
                ->modifyQueryUsing($this->getTabQuery($treatment));
        }

        return $tab;
    }

    abstract public function getTabQuery(Treatment $treatment): Closure;

    public function updatedActiveTab(): void
    {
        session(['custom_id' => $this->activeTab]);
        $this->resetPage();
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return session('custom_id') ?? 'すべて';
    }
}

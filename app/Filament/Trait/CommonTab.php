<?php

namespace App\Filament\Trait;

use Filament\Schemas\Components\Tabs\Tab;
use App\Models\Treatment;
use Closure;
use Filament\Resources\Concerns\HasTabs;


trait CommonTab
{
    use HasTabs;

    public function getTabs(): array
    {
        $tab = [];
        $tab['all'] = Tab::make();

        foreach (Treatment::all() as $treatment) {
            $tab[$treatment->patient->name] = Tab::make($treatment->patient->name)
                ->modifyQueryUsing($this->getTabQuery($treatment));
        }

        return $tab;
    }

    abstract public function getTabQuery(Treatment $treatment): Closure;
}

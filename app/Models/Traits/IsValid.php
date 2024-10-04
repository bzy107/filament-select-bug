<?php

namespace App\Models\Traits;

use App\Models\Scopes\IsValidScope;
use Illuminate\Database\Eloquent\SoftDeletes;

trait IsValid
{
    use SoftDeletes;

    public static function bootSoftDeletes(): void
    {
        //
    }

    public function initializeSoftDeletes(): void
    {
        //
    }

    public static function bootIsValid(): void
    {
        static::addGlobalScope(new IsValidScope());
    }

    protected function runSoftDelete(): void
    {
        $query = $this->setKeysForSaveQuery($this->newModelQuery());

        $columns = [$this->getDeletedAtColumn() => false];

        $this->{$this->getDeletedAtColumn()} = false;

        $query->update($columns);
    }

    public function restore(): bool
    {
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = true;

        $this->exists = true;

        $result = $this->save();

        $this->fireMOdelEvent('restored', false);

        return $result;
    }

    public function trashed(): bool
    {
        return $this->{$this->getDeletedAtColumn()} === false;
    }

    public function getDeletedAtColumn(): string
    {
        return 'is_valid';
    }
}

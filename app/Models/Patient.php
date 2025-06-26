<?php

namespace App\Models;

use App\Models\Traits\IsValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;
    use IsValid;

    protected $fillable = [
        'date_of_birth',
        'name',
        'type',
        'owner_id',
        'has_recovered',
        'is_valid',
    ];

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }
}

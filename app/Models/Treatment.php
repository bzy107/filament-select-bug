<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Models\Traits\IsValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    use HasFactory;
    use IsValid;

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    protected $fillable = [
        'description',
        'notes',
        'patient_id',
        'price',
        'has_prescription',
        'is_valid',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}

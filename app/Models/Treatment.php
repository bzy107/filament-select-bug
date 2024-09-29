<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Treatment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    protected $fillable = [
        'description',
        'notes',
        'patient_id',
        'price',
        'has_prescription',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}

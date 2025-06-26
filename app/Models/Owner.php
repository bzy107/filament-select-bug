<?php

namespace App\Models;

use App\Models\Traits\IsValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;
    use IsValid;

    protected $fillable = [
        'email',
        'name',
        'phone',
        'is_valid',
    ];

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }
}

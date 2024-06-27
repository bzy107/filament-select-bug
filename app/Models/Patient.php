<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date_of_birth',
        'name',
        'type',
        'has_recovered',
    ];

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }
}

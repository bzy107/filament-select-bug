<?php

namespace App\Models;

use App\Models\Traits\IsValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    use IsValid;

    protected $fillable = [
        'type',
        'date',
    ];

    public function Items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}

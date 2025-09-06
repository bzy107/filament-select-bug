<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use App\Models\Traits\IsValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;
    use IsValid;

    protected $fillable = [
        'type',
        'date',
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}

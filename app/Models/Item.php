<?php

namespace App\Models;

use Database\Factories\ItemFactory;
use App\Models\Order;
use App\Models\Traits\IsValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    /** @use HasFactory<ItemFactory> */
    use HasFactory;
    use IsValid;

    protected $fillable = [
        'name',
        'price',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}

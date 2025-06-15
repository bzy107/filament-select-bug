<?php

namespace App\Models;

use Database\Factories\ItemOrderFactory;
use App\Models\Traits\IsValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemOrder extends Model
{
    /** @use HasFactory<ItemOrderFactory> */
    use HasFactory;
    use IsValid;

    protected $table = 'item_order';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'item_id',
        'order_id',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

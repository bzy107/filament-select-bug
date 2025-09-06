<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Database\Seeder;

class ItemOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::all();
        foreach ($items as $item) {
            foreach (Order::all() as $order) {
                $item->orders()->attach([$order->id]);
            }
        }
    }
}

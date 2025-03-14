<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class UpdateProductQuantity extends Command
{
    protected $signature = 'products:update-quantity {quantity : The quantity to set for all products}';
    protected $description = 'Update quantity for all products';

    public function handle()
    {
        $quantity = $this->argument('quantity');

        try {
            Product::query()->where(['del_flag' => 0])->update(['quantity' => $quantity]);
            $this->info("Successfully updated quantity to {$quantity} for all products");
        } catch (\Exception $e) {
            $this->error("Failed to update product quantities: {$e->getMessage()}");
        }
    }
}

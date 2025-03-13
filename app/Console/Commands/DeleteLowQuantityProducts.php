<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class DeleteLowQuantityProducts extends Command
{
    protected $signature = 'products:delete-low-quantity';
    protected $description = 'Delete products with quantity less than 10';

    public function handle()
    {
        try {
            $count = Product::where('quantity', '<', 10)->update(['del_flag' => true]);
            $this->info("Successfully deleted {$count} products with low quantity");
        } catch (\Exception $e) {
            $this->error("Failed to delete products: {$e->getMessage()}");
        }
    }
}
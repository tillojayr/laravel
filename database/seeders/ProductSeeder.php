<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            Product::factory()->count(fake()->numberBetween(1, 5))->create([
                'user_id' => User::factory()->create()->id,
            ]);
        }
        Product::factory()->count(5)->create();
    }
}

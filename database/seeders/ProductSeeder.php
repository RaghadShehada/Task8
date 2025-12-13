<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run()
{
    Product::create([
        'name' => 'Laptop',
        'price' => 1200.50,
    ]);

    Product::create([
        'name' => 'Keyboard',
        'price' => 80.00,
    ]);

    Product::create([
        'name' => 'Mouse',
        'price' => 40.00,
    ]);

    Product::create([
        'name' => 'Headphones',
        'price' => 100.00,
    ]);

    Product::create([
        'name' => 'Monitor',
        'price' => 300.00,
    ]);
}

}

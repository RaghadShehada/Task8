<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier; // <-- مهم جدًا

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Alpha Supply',   'email' => 'alpha@example.com'],
            ['name' => 'Beta Traders',   'email' => 'beta@example.com'],
            ['name' => 'Gamma Import',   'email' => 'gamma@example.com'],
            ['name' => 'Delta Wholesale','email' => 'delta@example.com'],
            ['name' => 'Epsilon Co.',    'email' => 'epsilon@example.com'],
        ];

        foreach ($suppliers as $s) {
            Supplier::firstOrCreate($s);
        }
    }
}

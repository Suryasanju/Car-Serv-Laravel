<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ORM
        Product::create([
            'name' => 'Product Name 1',
            'category' => 'Product Category 1',
            'description' => 'Description of the product 1.',
            'price' => '199',
            'seller' => 'Chirag'
        ]);
        Product::create([
            'name' => 'Product Name 2',
            'category' => 'Product Category 2',
            'description' => 'Description of the product 2.',
            'price' => '299',
            'seller' => 'Chirag'
        ]);
        Product::create([
            'name' => 'Product Name 3',
            'category' => 'Product Category 3',
            'description' => 'Description of the product 3.',
            'price' => '149',
            'seller' => 'Chirag'
        ]);
        Product::create([
            'name' => 'Product Name 4',
            'category' => 'Product Category 4',
            'description' => 'Description of the product 4.',
            'price' => '599',
            'seller' => 'Chirag'
        ]);
    }
}

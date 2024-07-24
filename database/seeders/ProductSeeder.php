<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'product_name' => 'First product_name',
            'price' => '2000',
            'product_description' => 'product_description',
            'product_image' => 'test/image.jpq',
            'manufacturer' => 'manufacturer',
            'jan_code' => '00000011111',
            'category' => 'category',
            'tags' => 'tags',
            'remarks' => 'remarks',
            'company_id' => '1',
            'store_id' => '1',
            'public_flg' => 0,
            'is_deleted' => 0,
            'created_by' => 'system',
            'updated_by' => 'system',
        ]);
    }
}

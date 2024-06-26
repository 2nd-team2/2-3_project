<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => '상품이름'
            ,'price' => 10000
            ,'count' => 100
            ,'ml' => 355
            ,'img' => '/DB_img/liquor.jpg'
            ,'info' => '/DB_img/liquor.jpg'
        ];
        Product::create($data);
    }
}

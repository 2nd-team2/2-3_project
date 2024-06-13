<?php

namespace Database\Seeders;

use App\Models\product;
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
            ,'img' => '/img/best.png'
            ,'info' => '/img/bag.png'
        ];
        product::create($data);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Orderproduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderproductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'or_id' => 1
            ,'p_id' => 1
            ,'orp_count' => 10
        ];
        Orderproduct::create($data);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'u_id' => 1
            ,'or_buy_name' => '관리자'
            ,'or_buy_tel' => '0103337777'
            ,'or_get_name' => '관리자'
            ,'or_get_tel' => '0103337777'
            ,'or_get_addr' => '대구'
            ,'or_get_det_addr' => '중구'
            ,'or_get_post' => 1
            ,'or_sum' => 10000
        ];
        Order::create($data);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Exchange;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExchangeSeeder extends Seeder
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
            ,'orp_id' => 1
            ,'ex_addr' => '대구'
            ,'ex_det_addr' => '중구'
            ,'ex_post' => 1
            // ,'ex_reason' => '0'
        ];
        Exchange::create($data);
    }
}

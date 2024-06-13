<?php

namespace Database\Seeders;

use App\Models\Bag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BagSeeder extends Seeder
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
            ,'p_id' => 1
        ];
        Bag::create($data);
    }
}

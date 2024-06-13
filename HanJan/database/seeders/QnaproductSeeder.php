<?php

namespace Database\Seeders;

use App\Models\Qnaproduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QnaproductSeeder extends Seeder
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
            ,'qnp_content' => '상품문의내용'
            ,'qnp_answer' => '상품문의답변'
        ];
        Qnaproduct::create($data);
    }
}

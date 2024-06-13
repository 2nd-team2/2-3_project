<?php

namespace Database\Seeders;

use App\Models\Qna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QnaSeeder extends Seeder
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
            ,'qn_content' => '문의내용'
            ,'qn_answer' => '문의답변'
        ];
        Qna::create($data);
    }
}

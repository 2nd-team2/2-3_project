<?php

namespace Database\Seeders;

use App\Models\Infotl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfotlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'in_title' => '전통주설명제목'
            ,'in_content' => '전통주설명내용'
            ,'in_img' => '/img/bag.png'
        ];
        Infotl::create($data);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Bag;
use App\Models\Complete;
use App\Models\Exchange;
use App\Models\Infotl;
use App\Models\Notice;
use App\Models\Order;
use App\Models\Orderproduct;
use App\Models\product;
use App\Models\Qna;
use App\Models\Qnaproduct;
use App\Models\review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 단일 시더 생성
        $this->call(UserSeeder::class);
        $this->call(productSeeder::class);

        // 복수 시더 생성 - 배열안에 작성
        $this->call([
            BagSeeder::class,
            ExchangeSeeder::class,
            InfotlSeeder::class,
            NoticeSeeder::class,
            OrderSeeder::class,
            QnaproductSeeder::class,
            QnaSeeder::class,
            reviewSeeder::class,
            
            OrderproductSeeder::class,
            CompleteSeeder::class,
        ]);
        
        // 팩토리를 이용하여 대량 생성
        // 모델명::factory(반복수)->create();
        product::factory(50)->create();
        Bag::factory(10)->create();
        Notice::factory(5)->create();
        Orderproduct::factory(10)->create();
        Qna::factory(5)->create();
        Qnaproduct::factory(5)->create();
        review::factory(10)->create();
        
        // \App\Models\User::factory(10)->create();
    }
}

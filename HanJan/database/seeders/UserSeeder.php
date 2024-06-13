<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'email' => 'a@a.com'
            ,'password' => Hash::make('a')
            ,'name' => '관리자'
            ,'tel' => '0103337777'
            ,'addr' => '대구'
            ,'det_addr' => '중구'
            ,'post' => 1
            ,'birth' => '2024-01-01'
        ];
        User::create($data);
    }
}

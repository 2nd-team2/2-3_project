<?php

namespace Database\Seeders;

use App\Models\Complete;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'orp_id' => 1
        ];
        Complete::create($data);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->bigInteger('price')->comment('상품가격');
            $table->bigInteger('count')->comment('남은수량');
            $table->string('ml', 10)->comment('용량');
            $table->string('info', 100)->comment('상품정보, 이미지파일');
            $table->char('type', 1)->default('0')->comment('상품타입, 0: 탁주, 1: 과실주, 2: 증류주');
            $table->char('w_flg', 1)->default('0')->comment('날씨, 0:맑음, 1:흐림, 2:비');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

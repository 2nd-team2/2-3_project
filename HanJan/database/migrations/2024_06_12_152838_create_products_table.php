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
            $table->bigInteger('ml')->comment('용량');
            $table->string('img', 100)->comment('상품이미지, 이미지파일');
            $table->string('info', 100)->comment('상품정보, 이미지파일');
            $table->char('type', 1)->default('0')->comment('상품타입, 0: 탁주, 1: 과실주, 2: 증류주');
            $table->char('season', 1)->default('0')->comment('계절, 0:봄, 1:여름, 2:가을, 3:겨울')->nullable();
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

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('or_id');
            $table->bigInteger('u_id')->unsigned();
            $table->string('or_buy_name', 20)->comment('구매자 이름');
            $table->string('or_buy_tel', 20)->comment('구매자 연락처');
            $table->string('or_get_name', 20)->comment('받는사람 이름');
            $table->string('or_get_tel', 20)->comment('받는사람 연락처');
            $table->string('or_get_addr', 100)->comment('받는사람 주소');
            $table->string('or_get_det_addr', 100)->comment('받는사람 상세 주소');
            $table->integer('or_get_post')->comment('받는사람 우편번호');
            $table->bigInteger('or_sum')->comment('주문 합계');
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('orders');
    }
};

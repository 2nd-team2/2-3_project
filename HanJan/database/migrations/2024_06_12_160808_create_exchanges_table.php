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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id('ex_id');
            $table->bigInteger('u_id')->unsigned();
            $table->bigInteger('p_id')->unsigned();
            $table->string('ex_addr', 100)->comment('상품회수지');
            $table->string('ex_det_addr', 100)->comment('상품회수지상세');
            $table->integer('ex_post')->comment('상품회수지 우편번호');
            $table->char('ex_reason', 1)->comment('사유, 0: 단순변심, 1:상품배송오류, 2:구성품부족, 3:파손,결함');
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
        Schema::dropIfExists('exchanges');
    }
};

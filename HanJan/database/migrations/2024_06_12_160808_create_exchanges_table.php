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
            $table->bigInteger('orp_id')->unsigned();
            $table->string('ex_name', 20)->nullable()->comment('회수자');
            $table->string('ex_tel', 20)->nullable()->comment('회수자연락처');
            $table->string('ex_addr', 100)->nullable()->comment('상품회수지');
            $table->string('ex_det_addr', 100)->nullable()->comment('상품회수지상세');
            $table->integer('ex_post')->nullable()->comment('상품회수지 우편번호');
            $table->char('ex_reason', 1)->nullable()->comment('사유, 0: 단순변심, 1:상품배송오류, 2:구성품부족, 3:파손,결함, 4:기타');
            $table->string('ex_reason_etc', 500)->nullable()->comment('사유, 기타');
            $table->char('ex_flg', 1)->default(3)->comment('교환 flg, 0:신청완료, 1:상품회수중 2:처리완료 3:미신청');
            // $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('exchanges');
    }
};

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
            $table->integer('u_id')->unsigned();
            $table->integer('p_id')->unsigned();
            $table->string('ex_addr', 100)->comment('상품회수지');
            $table->string('ex_det_addr', 100)->comment('상품회수지상세');
            $table->integer('ex_post')->comment('상품회수지 우편번호');
            $table->char('ex_reason', 1)->comment('사유');
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

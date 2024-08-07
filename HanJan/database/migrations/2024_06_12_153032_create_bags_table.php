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
        Schema::create('bags', function (Blueprint $table) {
            $table->id('ba_id');
            $table->bigInteger('u_id')->unsigned();
            $table->bigInteger('p_id')->unsigned();
            $table->bigInteger('ba_count')->unsigned()->default(1);
            // $table->char('ba_chkflg', 1)->default('0')->comment('장바구니 체크 상태, 0: 미체크, 1: 체크');
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
        Schema::dropIfExists('bags');
    }
};

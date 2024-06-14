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
        Schema::create('qnaproducts', function (Blueprint $table) {
            $table->id('qnp_id');
            $table->bigInteger('u_id')->unsigned();
            $table->bigInteger('orp_id')->unsigned();
            $table->string('qnp_content', 1000)->comment('문의내용');
            $table->string('qnp_answer', 1000)->comment('문의답변');
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
        Schema::dropIfExists('qnaproducts');
    }
};

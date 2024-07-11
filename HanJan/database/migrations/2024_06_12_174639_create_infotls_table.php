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
        Schema::create('traditional_liquors', function (Blueprint $table) {
            $table->id('tl_id');
            $table->string('tl_title', 50)->comment('전통주제목');
            $table->string('tl_content', 1000)->comment('전통주설명');
            $table->string('tl_img', 100)->comment('전통주이미지');
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
        Schema::dropIfExists('traditional_liquors');
    }
};

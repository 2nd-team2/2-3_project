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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 30)->unique();
            $table->string('password', 255);
            $table->string('name', 20);
            $table->string('tel', 20)->comment('휴대 전화 번호');
            $table->string('addr', 100)->comment('주소');
            $table->string('det_addr', 100)->comment('상세주소');
            $table->integer('post')->comment('우편번호');
            $table->date('birth')->comment('생년월일');
            $table->char('age_chk', 1)->default('0')->comment('연령동의, 0: 미동의, 1: 동의');
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
        Schema::dropIfExists('users');
    }
};

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
        Schema::table('qnaproducts', function(Blueprint $table) {
            $table->foreign('u_id')->references('id')->on('users');
            $table->foreign('orp_id')->references('orp_id')->on('orderproducts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qnaproducts', function(Blueprint $table) {
            $table->dropForeign(['u_id']);
            $table->dropForeign(['orp_id']);
        });
    }
};

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
        Schema::table('bags', function(Blueprint $table) {
            $table->foreign('u_id')->references('id')->on('users');
            $table->foreign('p_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bags', function(Blueprint $table) {
            $table->dropForeign(['u_id']);
            $table->dropForeign(['p_id']);
        });
    }
};

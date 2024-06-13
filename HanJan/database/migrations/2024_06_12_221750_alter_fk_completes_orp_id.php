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
        Schema::table('completes', function(Blueprint $table) {
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
        Schema::table('completes', function(Blueprint $table) {
            $table->dropForeign(['orp_id']);
        });
    }
};

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
        Schema::table('orderproducts', function(Blueprint $table) {
            $table->foreign('p_id')->references('id')->on('products');
            $table->foreign('or_id')->references('or_id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderproducts', function(Blueprint $table) {
            $table->dropForeign(['p_id']);
            $table->dropForeign(['or_id']);
        });
    }
};

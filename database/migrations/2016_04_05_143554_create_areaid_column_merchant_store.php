<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaidColumnMerchantStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_store_address', function ($table) {
            $table->integer('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('areas');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_store_address', function($table)
        {
            $table->dropColumn('area_id');
        });
    }
}

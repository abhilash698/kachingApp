<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewColumnsSupermerchant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_store', function ($table) {
            $table->boolean('is_parent')->default(0); 
            $table->boolean('is_child')->default(0);       
            $table->integer('parent_id')->unsigned();      
        });

        Schema::table('offers', function ($table) {
            $table->boolean('is_parent')->default(0); 
            $table->boolean('is_child')->default(0);       
            $table->integer('parent_id')->unsigned();      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_store', function($table)
        {
            $table->dropColumn('is_parent');
            $table->dropColumn('is_child');
            $table->dropColumn('parent_id');
        });

        Schema::table('offers', function($table)
        {
            $table->dropColumn('is_parent');
            $table->dropColumn('is_child');
            $table->dropColumn('parent_id');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSmsCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sms_code', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mobile_id')->unsigned();
            $table->foreign('mobile_id')->references('id')->on('temp_mobile')->onDelete('cascade');
            $table->string('code',6);  
            $table->string('reference_id',24);  
            $table->boolean('status')->default(0);       
            $table->timestamps();
            $table->unique(['code', 'status']);
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
        Schema::drop('user_sms_code');
    }
}

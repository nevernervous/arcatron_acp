<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_statuses', function (Blueprint $table) {
           $table->dropColumn('ack');
        });

        Schema::create('user_ack', function (Blueprint $table){
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('live_id');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('live_id')->references('id')->on('live_statuses')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_ack');
        Schema::table('live_statuses', function (Blueprint $table) {
            $table->boolean('ack')->default(false);
        });
    }
}

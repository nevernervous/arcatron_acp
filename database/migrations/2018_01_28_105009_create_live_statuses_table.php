<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_ip');
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('department_name');
            $table->string('device_name');
            $table->dateTime('date');
            $table->unsignedInteger('critical_level');
            $table->unsignedInteger('alarm_state');
            $table->boolean('ack')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_statuses');
    }
}

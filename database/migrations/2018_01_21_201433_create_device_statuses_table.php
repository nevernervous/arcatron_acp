<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_statues', function (Blueprint $table) {
           $table->integer('id');
           $table->string('device_ip');
           $table->string('company_name');
           $table->string('department_name');
           $table->string('device_name');
           $table->dateTime('date');
           $table->unsignedInteger('critical_level');
           $table->unsignedInteger('alarm_state');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

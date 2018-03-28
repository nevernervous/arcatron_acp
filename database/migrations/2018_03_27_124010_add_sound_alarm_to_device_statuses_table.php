<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoundAlarmToDeviceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_statuses', function (Blueprint $table) {
            $table->integer('sound_alarm')->after('alarm_state')->default(0);;
        });

        Schema::table('live_statuses', function (Blueprint $table) {
            $table->integer('sound_alarm')->after('alarm_state')->default(0);;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_statuses', function (Blueprint $table) {
            $table->dropColumn('sound_alarm');
        });

        Schema::table('live_statuses', function (Blueprint $table) {
            $table->dropColumn('sound_alarm');
        });
    }
}

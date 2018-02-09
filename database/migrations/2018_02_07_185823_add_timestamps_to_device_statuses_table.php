<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToDeviceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_statuses', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('live_statuses', function (Blueprint $table) {
            $table->timestamps();
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
            $table->dropTimestamps();
        });

        Schema::table('live_statuses', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}

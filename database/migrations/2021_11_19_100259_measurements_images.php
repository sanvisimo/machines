<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MeasurementsImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measurement_configs', function (Blueprint $table) {
            $table->string('image')->nullable()->after('position');
        });
        Schema::table('measurements', function (Blueprint $table) {
            $table->string('image')->nullable()->after('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('measurement_configs', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('measurements', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMeasurements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('measurement_configs', function (Blueprint $table) {
        $table->boolean('rpm')->nullable()->after('pressure_max')->default(false);
      });
      Schema::table('measurements', function (Blueprint $table) {
        $table->string('rpm')->nullable()->after('pressure');
        $table->string('vibrations_type_SPM_2')->nullable()->after('vibrations_type_SPM');
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
        $table->dropColumn('rpm');
      });
      Schema::table('measurements', function (Blueprint $table) {
        $table->dropColumn('rpm');
        $table->dropColumn('vibrations_type_spm_2');
      });
    }
}

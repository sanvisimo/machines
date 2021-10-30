<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurement_configs', function (Blueprint $table) {
            $table->id();
            $table->boolean('lubricant_levels');
            $table->boolean('lubricant_appearence');
            $table->boolean('leakage');
            $table->boolean('temperature');
            $table->integer('temperature_min')->nullable();
            $table->integer('temperature_max')->nullable();
            $table->boolean('pressure');
            $table->integer('pressure_min')->nullable();
            $table->integer('pressure_max')->nullable();
            $table->boolean('vibrations_type_SPM');
            $table->boolean('vibrations_type_SISM');
            $table->foreignId('component_id');
            $table->foreignId('position');
            $table->foreignId('article_id')->nullable();
            $table->foreignId('control_plan_config_id');
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
        Schema::dropIfExists('measurement_cent_configs');
    }
}

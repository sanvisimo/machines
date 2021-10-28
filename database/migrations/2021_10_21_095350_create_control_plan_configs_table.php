<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlPlanConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_plan_configs', function (Blueprint $table) {
            $table->id();
            $table->boolean('contract')->default(true);
            $table->boolean('cost')->default(true);
            $table->boolean('periodicity')->default(true);
            $table->boolean('global_conditions')->default(true);
            $table->boolean('machine_status')->default(true);
            $table->boolean('casing_integrity_check')->default(true);
            $table->boolean('nameplate_integrity')->default(true);
            $table->boolean('rpm')->default(true);
            $table->boolean('check_pressure_gauges');
            $table->boolean('check_sight_glasses_oil');
            $table->boolean('check_sight_glasses_water');
            $table->boolean('check_thermometers');
            $table->boolean('electric_absorption');
            $table->boolean('check_cleaning_protective_grid');
            $table->boolean('check_cleaning_junction_box');
            $table->boolean('check_integrity_flexible_electric');
            $table->boolean('check_ground_connections');
            $table->boolean('check_ground_connections_notes');
            $table->boolean('thermography');
            $table->boolean('laser_alignment');
            $table->foreignId('machine_id');
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
        Schema::dropIfExists('misuration_configs');
    }
}

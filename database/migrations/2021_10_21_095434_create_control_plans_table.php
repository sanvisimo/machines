<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_plans', function (Blueprint $table) {
            $table->id();
            $table->boolean('contract')->default(true);
            $table->float('cost',10,2);
            $table->integer('periodicity');
            $table->string('periodicity_note')->nullable();
            $table->enum('global_conditions', ['good','attention','intervent'])->nullable();
            $table->enum('machine_status',['run','stop', 'maintenance'])->nullable();
            $table->boolean('casing_integrity_check')->nullable();
            $table->string('casing_integrity_check_notes')->nullable();
            $table->boolean('nameplate_integrity')->nullable();
            $table->string('nameplate_integrity_notes')->nullable();
            $table->integer('rpm')->nullable();
            $table->boolean('check_pressure_gauges')->nullable();
            $table->string('check_pressure_gauges_notes')->nullable();
            $table->boolean('check_sight_glasses_oil')->nullable();
            $table->string('check_sight_glasses_oil_notes')->nullable();
            $table->boolean('check_sight_glasses_water')->nullable();
            $table->string('check_sight_glasses_water_notes')->nullable();
            $table->boolean('check_thermometers')->nullable();
            $table->string('check_thermometers_notes')->nullable();
            $table->integer('electric_absorption')->nullable();
            $table->string('electric_absorption_notes')->nullable();
            $table->boolean('check_cleaning_protective_grid')->nullable();
            $table->string('check_cleaning_protective_grid_notes')->nullable();
            $table->boolean('check_cleaning_junction_box')->nullable();
            $table->string('check_cleaning_junction_box_notes')->nullable();
            $table->boolean('check_integrity_flexible_electric')->nullable();
            $table->string('check_integrity_flexible_electric_notes')->nullable();
            $table->boolean('check_ground_connections')->nullable();
            $table->string('check_ground_connections_notes')->nullable();
            $table->string('thermography')->nullable();
            $table->string('laser_alignment')->nullable();
            $table->foreignId('machine_id');
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
        Schema::dropIfExists('control_plans');
    }
}

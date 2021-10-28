<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('manufacturer_code', 10);
            $table->string('manufacturer_description', 40);
            $table->string('type')->nullable();
            $table->string('serial_number', 20);
            $table->string('revision', 5);
            $table->enum('state', array('active', 'suspended', 'not_operative'));
            $table->float('power');
            $table->float('engine_side_rpm');
            $table->float('process_side_rpm');
            $table->float('pressure_min');
            $table->float('pressure_max');
            $table->float('temperature_min');
            $table->float('temperature_max');
            $table->string('documentation');
            $table->date('activation_date');
            $table->string('note');
            $table->string('internal_note');
            $table->foreignId('plant_id')->nullable();
            $table->foreignId('config_plan_config_id')->nullable();
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
        Schema::dropIfExists('machines');
    }
}

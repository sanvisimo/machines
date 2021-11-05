<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->boolean('anomaly')->nullable();
            $table->string('anomaly_notes')->nullable();
            $table->enum('lubricant_levels', array('low', 'medium', 'high'))->nullable();
            $table->string('lubricant_levels_notes')->nullable();
            $table->enum('lubricant_appearence', ['clear', 'turbid', 'dark'])->nullable();
            $table->string('lubricant_appearence_notes')->nullable();
            $table->boolean('leakage')->nullable();
            $table->string('leakage_notes')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('pressure')->nullable();
            $table->string('vibrations_type_SPM')->nullable();
            $table->string('vibrations_type_SISM_1')->nullable();
            $table->string('vibrations_type_SISM_2')->nullable();
            $table->string('vibrations_type_SISM_3')->nullable();
            $table->foreignId('control_plan_id');
            $table->foreignId('component_id');
            $table->string('position');
            $table->foreignId('article_id')->nullable();
            $table->foreignId('measurement_config_id');
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
        Schema::dropIfExists('measurements');
    }
}

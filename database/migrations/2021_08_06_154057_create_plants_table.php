<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('plant', 20)->unique();
            $table->string('description', 40);
            $table->string('note');
            $table->enum('plant_state', array('active', 'suspended', 'cancel'));
            $table->string('internal_note');
            $table->string('documents')->nullable();
            $table->foreignId('establishment_id');
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
        Schema::dropIfExists('plants');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('machine_id');
            $table->foreignId('component_category_id');
            $table->foreignId('component_sub_category_id');
            $table->string('constructor', 40);
            $table->string('model', 40);
            $table->string('serial_number', 40);
            $table->string('description');
            $table->integer('vibrations');
            $table->integer('temperature');
            $table->integer('pressure');
            $table->integer('payload');
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
        Schema::dropIfExists('components');
    }
}

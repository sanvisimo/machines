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
            $table->string('name')->unique();
            $table->string('address');
            $table->string('phone');
            $table->string('image')->nullable();
            $table->foreignId('plant_id');
            $table->timestamps();

            $table->string('published')->nullable();
            $table->date('birthday');
            $table->dateTime('published_at', $precision = 0);
            $table->tinyInteger('active');
            $table->string('permissions')->nullable();
            $table->string('country_code');
            $table->string('meta')->nullable();
            $table->decimal('price', $precision = 8, $scale = 2);
            $table->string('password');
            $table->string('size');
            $table->string('longname');
            $table->string('slug');
            $table->string('excerpt');
            $table->string('biography');
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

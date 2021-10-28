<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->date('expiration');
            $table->foreignId('machine_id');
            $table->string('description');
            $table->enum('type', ['maintenance', 'control_plan','maintenance_no', 'control_plan_no']);
            $table->boolean('contract')->default(true);
            $table->boolean('fix_fee')->default(true);;
            $table->boolean('active')->default(true);;
            $table->integer('activitable_id')->nullable();
            $table->string('activitable_type')->nullable();
            $table->integer('element_id');
            $table->string('element_type');
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
        Schema::dropIfExists('agendas');
    }
}

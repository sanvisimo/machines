<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('work_permit',20)->nullable();
            $table->enum('type', ['maintenance', 'maintenance_no'])->nullable();
            $table->foreignId('user_id')->nullable();
            $table->datetime('opening_date')->nullable();
            $table->datetime('onsite_intervention')->nullable();
            $table->datetime('closed_on')->nullable();
            $table->integer('duration')->nullable();
            $table->float('indicative_cost', 10,2)->nullable();
            $table->string('drawing')->nullable();
            $table->string('position')->nullable();
            $table->boolean('extra_fee')->nullable();
            $table->string('task_notes')->nullable();
            $table->string('internal_notes')->nullable();
            $table->foreignId('machine_id')->nullable();
            $table->foreignId('component_id')->nullable();
            $table->foreignId('managed_article_id')->nullable();
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
        Schema::dropIfExists('maintenances');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagedArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managed_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id');
            $table->string('reference');
            $table->string('customer_part_number',18);
            $table->string('measurement_point');
            $table->string('note')->nullable();
            $table->string('attachment')->nullable();
            $table->foreignId('component_id');
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
        Schema::dropIfExists('managed_articles');
    }
}

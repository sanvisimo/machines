<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('part_number',18)->unique();
            $table->string('description',40);
            $table->string('material',40);
            $table->string('drawing', 40);
            $table->string('eb_part_number', 18);
            $table->string('product_type', 4);
            $table->enum('state', array('active', 'suspended', 'blocked'));
            $table->string('external_part_number', 18);
            $table->string('supplier_code', 18)->nullable();
            $table->string('supplier_description', 40)->nullable();
            $table->enum("MU", array('PZ', 'MT', 'LT', 'KT'));
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
        Schema::dropIfExists('articles');
    }
}

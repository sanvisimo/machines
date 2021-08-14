<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('piva')->unique();
            $table->string('cf')->unique();
            $table->string('email');
            $table->string('address');
            $table->string('phone');
            $table->string('fax');
            $table->string('contact');
            $table->string('image')->nullable();;
            $table->foreignId('customer_id');
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
        Schema::dropIfExists('establishments');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FilesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('machines', function (Blueprint $table) {
            $table->string('documentation_name')->nullable();
        });
        Schema::table('managed_articles', function (Blueprint $table) {
            $table->string('attachment_name')->nullable();
        });
        Schema::table('plants', function (Blueprint $table) {
            $table->string('documents_name')->nullable();
        });
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('attachment_name')->nullable();
        });
        Schema::table('control_plans', function (Blueprint $table) {
            $table->string('laser_alignment_documentation_name')->nullable();
            $table->string('thermography_documentation_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

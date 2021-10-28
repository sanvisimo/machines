<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factories', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code', 10)->unique();
            $table->string('customer_name', 60);
            $table->string('other_customer_name', 60);
            $table->string('iso', 3);
            $table->string('vat_number', 16);
            $table->string('fiscal_code', 16);
            $table->string('address', 40)->nullable();
            $table->string('city', 40)->nullable();
            $table->string('po_box')->nullable();
            $table->string('province', 3);
            $table->string('country', 3);
            $table->string('crm_c4c_code', 20);
            $table->enum('type', array('customer', 'factory', 'vendor','subcontractor'));
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->string('contact_person');
            $table->date('activation_date');
            $table->string('language');
            $table->foreignId('leader_code')->nullable();
            $table->string('note')->nullable();
            $table->string('main_activity')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('maintenance_contract');
            $table->foreignId('fixfee_contract');
            $table->foreignId('monitoring_contract');
            $table->index('leader_code');
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
        Schema::dropIfExists('clients');
    }
}

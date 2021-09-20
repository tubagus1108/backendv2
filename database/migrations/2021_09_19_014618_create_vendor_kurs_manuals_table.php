<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorKursManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_kurs_manual', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name')->nullable();
            $table->string('rate_type')->nullable();
            $table->double('buy')->nullable();
            $table->double('sell')->nullable();
            $table->double('kurs_converted')->nullable();
            $table->integer('id_currency')->nullable();
            $table->integer('id_currency_to')->nullable();
            $table->double('customer_fee')->nullable();
            $table->integer('status_active')->nullable();
            $table->timestamp('last_update')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_kurs_manuals');
    }
}

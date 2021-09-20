<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt', function (Blueprint $table) {
            $table->id();
            $table->integer('id_group')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('des_country');
            $table->string('service')->nullable();
            $table->string('acc_number')->nullable();
            $table->string('id_type')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone_number')->nullable();
            $table->integer('id_number')->nullable();
            $table->string('country')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('province_receipt')->nullable();
            $table->text('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('status')->nullable();
            $table->text('additional_info')->nullable();
            $table->string('branch')->nullable();
            $table->string('transit_code')->nullable();
            $table->string('sort_code')->nullable();
            $table->string('swift')->nullable();
            $table->string('bsb_code')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('iban')->nullable();
            $table->string('account_type')->nullable();
            $table->string('city')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('region')->nullable();
            $table->string('bank_add')->nullable();
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
        Schema::dropIfExists('receipts');
    }
}

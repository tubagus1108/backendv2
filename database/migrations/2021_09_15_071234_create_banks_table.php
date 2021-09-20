<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank-admin', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->nullable();
            $table->string('acc_name')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('cab_bank')->nullable();
            $table->string('icon_bank')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('banks');
    }
}

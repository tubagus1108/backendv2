<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_list', function (Blueprint $table) {
            $table->id();
            $table->string('name_bank')->nullable();
            $table->integer('currency_id')->nullable();
            $table->integer('code_tranglo')->nullable();
            $table->integer('sentbe_code')->nullable();
            $table->integer('service_id')->nullable();
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
        Schema::dropIfExists('bank_lists');
    }
}

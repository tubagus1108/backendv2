<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_num')->nullable();
            $table->integer('rec_id')->nullable();
            $table->decimal('customer_rate')->nullable();
            $table->decimal('fee')->nullable();
            $table->integer('status')->nullable();
            $table->string('status_trx')->nullable();
            $table->string('status_trx_admin')->nullable();
            $table->text('remarks_admin')->nullable();
            $table->string('status_order')->nullable();
            $table->text('remarks_order')->nullable();
            $table->string('status_paid')->nullable();
            $table->decimal('recipient_gets')->nullable();
            $table->decimal('send')->nullable();
            $table->string('vendor_name')->nullable();
            $table->decimal('vendor_rate')->nullable();
            $table->decimal('vendor_fee')->nullable();
            $table->string('status_vendor')->nullable();
            $table->integer('bank_id')->nullable();
            $table->integer('voucher_id')->nullable();
            $table->integer('source_id')->nullable();
            $table->integer('purpose_id')->nullable();
            $table->timestamp('countdown_date')->nullable();
            $table->integer('approve_user_1')->nullable();
            $table->timestamp('approve_at_1')->nullable();
            $table->integer('status_approve_1')->nullable();
            $table->integer('approve_user_2')->nullable();
            $table->timestamp('approve_at_2')->nullable();
            $table->integer('status_approve_2')->nullable();
            $table->integer('update_by')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('country_residence')->nullable();
            $table->string('user_hp')->nullable();
            $table->string('business_name')->nullable();
            $table->string('reg_business_name')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('company_type')->nullable();
            $table->string('company_role')->nullable();
            $table->string('company_website')->nullable();
            $table->string('place_birth');
            $table->date('date_birth');
            $table->text('company_address')->nullable();
            $table->text('address');
            $table->integer('country_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('zip');
            $table->string('citizen');
            $table->string('occupation')->nullable();
            $table->string('tlp')->nullable();
            $table->string('id_card_type');
            $table->string('id_card_num');
            $table->string('foto_id_card')->nullable();
            $table->string('foto_selfie_id_card')->nullable();
            $table->integer('type_user');
            $table->string('foto_npwp')->nullable();
            $table->string('foto_izin_company')->nullable();
            $table->string('otp')->nullable();
            $table->string('approve_1')->nullable();
            $table->integer('admin_approve_1')->nullable();
            $table->dateTime('approvedate_1')->nullable();
            $table->string('approve_2')->nullable();
            $table->integer('admin_approve_2')->nullable();
            $table->dateTime('approvedate_2')->nullable();
            $table->string('status_bi_check')->nullable();
            $table->string('user_status')->nullable();
            $table->string('referral_code')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

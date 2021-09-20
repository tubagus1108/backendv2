<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_check', function (Blueprint $table) {
            $table->id();
            $table->text('nama')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('terduga')->nullable();
            $table->string('kode_densus')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tgl_lahir')->nullable();
            $table->string('warga_negara')->nullable();
            $table->text('alamat')->nullable();
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
        Schema::dropIfExists('bi_checks');
    }
}

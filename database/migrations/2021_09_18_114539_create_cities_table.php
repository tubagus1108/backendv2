<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppatk_bi_city', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_city_ppatk')->nullable();
            $table->string('kode_city_bi')->nullable();
            $table->integer('id_province')->nullable();
            $table->string('nama_city_ppatk')->nullable();
            $table->string('nama_city_bi')->nullable();
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
        Schema::dropIfExists('cities');
    }
}

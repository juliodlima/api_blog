<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('street');
            $table->string('suite');
            $table->string('city');
            $table->string('zipcode');
            $table->unsignedBigInteger('geo');
            $table->foreign('geo')->references('id')->on('geos');
            $table->timestamps();
            $table->softDeletes(); //permite exclusão lógica
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}

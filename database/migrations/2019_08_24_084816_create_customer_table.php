<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('page_id');
            $table->integer('type');
            $table->integer('count_message');
            $table->string('id_tags')->nullable();
            $table->timestamps();
        });
        Schema::create('shift', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_shift');;
            $table->string('timestart');
            $table->string('timeend');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_tag');
            $table->integer('id_tag');
            $table->integer('type');
            $table->timestamps();
        });

        Schema::create('config_auto_tag', function (Blueprint $table) {
            $table->integer('position');
            $table->string('token');
            $table->string('page_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_list');
    }
}

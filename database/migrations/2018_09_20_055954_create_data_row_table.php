<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataRowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('task_id');
            $table->string('type');// field type: text, textarea, dropdown
            $table->string('validation_rules');
            $table->string('api_action')->nullable();//will decide whether the field has to hit any api
            $table->string('label');
            $table->string('order');
            $table->string('relationship')->nullable(); //will hold the meta data about the relation 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_rows');
    }
}

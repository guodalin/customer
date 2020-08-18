<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 90)->nullable();
            $table->string('avatar')->comment('头像')->nullable();
            $table->string('info')->comment('简介')->nullable();
            $table->bigInteger('hits')->default(0)->comment('打开次数');
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
        Schema::dropIfExists('dy');
    }
}

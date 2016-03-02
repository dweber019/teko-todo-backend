<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TasklistUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasklist_user', function (Blueprint $table) {
            $table->integer('userId')
              ->unsigned();
            $table->integer('tasklistId')
              ->unsigned();

            $table->foreign('userId')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');

            $table->foreign('tasklistId')
              ->references('id')
              ->on('tasklists')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasklist_user');
    }
}

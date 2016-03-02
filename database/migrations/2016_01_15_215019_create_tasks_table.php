<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')
              ->nullable();
            $table->dateTime('dueDate')
              ->nullable();
            $table->boolean('favorite')
              ->default(false);
            $table->enum('status', ['open', 'inprocess', 'closed', 'archived'])
              ->default('open');
            $table->integer('tasklistId')
              ->nullable()
              ->unsigned();
            $table->integer('userId')
              ->unsigned();
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');

            $table->foreign('tasklistId')
              ->references('id')
              ->on('tasklists')
              ->onDelete('cascade');

            $table->foreign('userId')
              ->references('id')
              ->on('users')
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
        Schema::drop('tasks');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('result');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            
            $table->index(['created_at']);
            $table->index(['category_id']);
            $table->index(['user_id']);

            $table->foreign('category_id')
                    ->references('id')->on('categories')
                    ->onDelete('cascade')
                    ->onUpdate('no action');
            
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('lessons');
    }

}

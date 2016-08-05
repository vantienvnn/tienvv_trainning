<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonWordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_words', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned();
            $table->integer('word_id')->unsigned();
            $table->integer('word_answer_id')->unsigned();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->index(['created_at']);
            $table->index(['lesson_id']);
            $table->index(['word_id']);
            $table->index(['word_answer_id']);

            $table->foreign('lesson_id')
            ->references('id')->on('lessons')
            ->onDelete('cascade')
            ->onUpdate('no action');

            $table->foreign('word_id')
            ->references('id')->on('words')
            ->onDelete('cascade')
            ->onUpdate('no action');

            $table->foreign('word_answer_id')
            ->references('id')->on('word_answers')
            ->onDelete('cascade')
            ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lesson_words');
    }

}

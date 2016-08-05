<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordAnswersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('word_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('word_id')->unsigned();
            $table->smallInteger('correct');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            
            $table->index(['word_id']);
            $table->index(['created_at']);
            
            $table->foreign('word_id')
                    ->references('id')->on('words')
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
        Schema::drop('word_answers');
    }

}

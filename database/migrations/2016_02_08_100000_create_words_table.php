<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
            $table->integer('category_id')->unsigned();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            
            $table->index(['created_at']);
            $table->index(['category_id']);
            
            $table->foreign('category_id')
                    ->references('id')->on('categories')
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
        Schema::drop('words');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('original_post');
            $table->foreign('original_post')
                ->references('id')->on('posts')
                ->onDelete('restrict');
            $table->unsignedBigInteger('comment_author');
            $table->foreign('comment_author')
                ->references('id')->on('users')
                ->onDelete('restrict');
            $table->text('content', 2000);
            $table->timestamps();

            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}

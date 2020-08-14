<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('post_title')->default('No Title Given.');
            $table->text('post_content');
            $table->text('post_trimmed_desc');
            $table->unsignedBigInteger('post_author');
                    $table->foreign('post_author')
                        ->references('id')->on('users')
                        ->onDelete('restrict');
            $table->boolean('post_active')->default('1')->comment('1=YES, 0=NO');
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
        Schema::dropIfExists('posts');
    }
}

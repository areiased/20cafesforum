<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('user_realname', 50);
            $table->string('username', 20)->unique();
            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 256);       // 256 is the recommended lenght for bcrypt hashes
            $table->boolean('user_role')->default('0')->comment('0=USER; 1=ADMIN');
            $table->boolean('user_active')->default('1')->comment('0=INACTIVE; 1=ACTIVE');
            $table->rememberToken();
            $table->timestamps();   // auto creates "created_at" and "modified_at" fields

            $table->index('id');   // makes the table faster
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

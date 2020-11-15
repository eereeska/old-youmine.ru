<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->nullable();
            $table->boolean('admin')->default(false);
            $table->boolean('moderator')->default(false);
            $table->integer('balance')->default(0);
            $table->integer('skin_id')->default(1);
            $table->string('ip')->nullable();
            $table->string('country')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
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
            $table->string('uuid')->unique()->index()->nullable();
            $table->boolean('admin')->default(false);
            $table->boolean('moderator')->default(false);
            $table->integer('balance')->default(0);
            $table->string('vk_id')->unique()->index();
            $table->string('vk_first_name');
            $table->string('vk_last_name');
            $table->text('vk_avatar');
            $table->string('reg_ip');
            $table->string('ip')->nullable();
            $table->string('reg_country')->nullable();
            $table->string('country')->nullable();
            $table->timestamp('sub_expire_at')->useCurrent();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
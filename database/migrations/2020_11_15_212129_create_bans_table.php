<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBansTable extends Migration
{
    public function up()
    {
        Schema::create('bans', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('reason')->nullable();
            $table->timestamp('expire_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bans');
    }
}
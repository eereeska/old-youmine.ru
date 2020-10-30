<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkinsTable extends Migration
{
    public function up()
    {
        Schema::create('skins', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id')->unsigned();
            $table->boolean('slim')->default(false);
            $table->text('texture');
            $table->text('signature');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skins');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user1_id')->unsigned()->nullable();
            $table->bigInteger('user2_id')->unsigned()->nullable();
            $table->unique(['user1_id', 'user2_id']);
            $table->timestamps();

            $table->foreign('user1_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user2_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}

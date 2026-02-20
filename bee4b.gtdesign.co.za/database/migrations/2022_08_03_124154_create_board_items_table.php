<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->bigInteger('board_id')->unsigned();
            $table->string('priority')->nullable();
            $table->datetime('deadline')->nullable();
            $table->boolean('completed')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('phase_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('board_items')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('phase_id')->references('id')->on('phases')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_items');
    }
}

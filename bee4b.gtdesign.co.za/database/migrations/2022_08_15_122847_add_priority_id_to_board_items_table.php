<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityIdToBoardItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('board_items', function (Blueprint $table) {
            $table->bigInteger('priority_id')->unsigned()->nullable();

            $table->foreign('priority_id')->references('id')->on('priorities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('board_items', function (Blueprint $table) {
            //
        });
    }
}

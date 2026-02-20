<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToBoardItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('board_items', function (Blueprint $table) {
            $table->bigInteger('category_id')->unsigned()->nullable();

            $table->foreign('category_id')->references('id')->on('board_item_categories')->onDelete('set null');
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

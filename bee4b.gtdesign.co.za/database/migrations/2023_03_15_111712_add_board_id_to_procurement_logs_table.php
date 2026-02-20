<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoardIdToProcurementLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procurement_logs', function (Blueprint $table) {
            $table->bigInteger('board_id')->unsigned()->nullable()->after('fye');

            $table->foreign('board_id')->references('id')->on('boards')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procurement_logs', function (Blueprint $table) {
            //
        });
    }
}

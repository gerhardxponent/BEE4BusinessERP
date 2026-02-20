<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamToBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->bigInteger('consultant_id')->unsigned()->nullable();
            $table->bigInteger('analyst_id')->unsigned()->nullable();
            $table->bigInteger('jnrAnalyst_id')->unsigned()->nullable();

            $table->foreign('consultant_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('analyst_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('jnrAnalyst_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boards', function (Blueprint $table) {
            //
        });
    }
}

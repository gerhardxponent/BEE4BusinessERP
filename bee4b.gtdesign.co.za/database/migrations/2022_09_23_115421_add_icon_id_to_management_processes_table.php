<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconIdToManagementProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('management_processes', function (Blueprint $table) {
            $table->bigInteger('icon_id')->unsigned()->nullable();

            $table->foreign('icon_id')->references('id')->on('icons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('management_processes', function (Blueprint $table) {
            //
        });
    }
}

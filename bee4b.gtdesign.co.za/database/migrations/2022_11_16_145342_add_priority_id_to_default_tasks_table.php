<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityIdToDefaultTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('default_tasks', function (Blueprint $table) {
            $table->bigInteger('priority_id')->unsigned()->nullable()->after('priority');

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
        Schema::table('default_tasks', function (Blueprint $table) {
            //
        });
    }
}

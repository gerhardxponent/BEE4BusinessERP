<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProcurementLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procurement_logs', function (Blueprint $table) {
            $table->date('date_allocated')->nullable()->after('client_id');
            $table->date('due_date')->nullable()->after('date_allocated');
            $table->bigInteger('pp_analyst_id')->unsigned()->nullable()->after('date_allocated');
            $table->date('fye')->nullable()->after('pp_analyst_id');
            $table->string('scorecard_number')->nullable();
            $table->text('notes')->nullable();

            $table->foreign('pp_analyst_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

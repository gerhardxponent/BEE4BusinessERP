<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWipColsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->text('report_notes')->after('report_status_id')->nullable();
            $table->date('due_date_report')->after('report_notes')->nullable();
            $table->bigInteger('audit_progress_id')->after('planned_audit_date')->unsigned()->nullable();

            $table->foreign('audit_progress_id')->references('id')->on('audit_progress')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}

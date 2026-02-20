<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->bigInteger('engagement_type_id')->unsigned()->nullable();
            $table->bigInteger('report_status_id')->unsigned()->nullable();
            $table->bigInteger('rating_agency_id')->unsigned()->nullable();
            $table->bigInteger('bee_level_id')->unsigned()->nullable();
            
            $table->date('planned_audit_date')->nullable();
            $table->date('date_cert_issued')->nullable();
            $table->date('date_engaged')->nullable();

            $table->foreign('engagement_type_id')->references('id')->on('engagement_types')->onDelete('set null');
            $table->foreign('report_status_id')->references('id')->on('report_statuses')->onDelete('set null');
            $table->foreign('rating_agency_id')->references('id')->on('rating_agencies')->onDelete('set null');
            $table->foreign('bee_level_id')->references('id')->on('bee_levels')->onDelete('set null');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditFileDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_file_dates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('audit_id')->unsigned();
            $table->bigInteger('audit_reference_id')->unsigned();
            $table->date('date_requested');
            $table->date('due_date');
            $table->timestamps();

            $table->foreign('audit_id')->references('id')->on('audits')->onDelete('cascade');
            $table->foreign('audit_reference_id')->references('id')->on('audit_references')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_file_dates');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('file_id')->unsigned()->nullable();
            $table->bigInteger('audit_reference_id')->unsigned()->nullable();
            $table->date('date_requested')->nullable();
            $table->date('due_date')->nullable();
            $table->date('date_last_checked')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('audit_reference_id')->references('id')->on('audit_references')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_files');
    }
}

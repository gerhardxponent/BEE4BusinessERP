<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExcelColsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->datetime('fye')->nullable()->default(null);
            $table->bigInteger('size')->unsigned()->nullable();
            $table->bigInteger('sector')->unsigned()->nullable();
            $table->bigInteger('region')->unsigned()->nullable();
            $table->bigInteger('manager')->unsigned()->nullable();
            $table->bigInteger('analyst')->unsigned()->nullable();
            $table->bigInteger('state')->unsigned()->nullable();
            $table->datetime('current_certificate_expiry')->nullable()->default(null);
            $table->datetime('deadline')->nullable()->default(null);
            $table->datetime('next_report_required')->nullable()->default(null);
            $table->datetime('next_audit')->nullable()->default(null);

            $table->foreign('size')->references('id')->on('sizes')->onDelete('set null');
            $table->foreign('sector')->references('id')->on('sectors')->onDelete('set null');
            $table->foreign('region')->references('id')->on('regions')->onDelete('set null');
            $table->foreign('manager')->references('id')->on('users')->onDelete('set null');
            $table->foreign('analyst')->references('id')->on('users')->onDelete('set null');
            $table->foreign('state')->references('id')->on('states')->onDelete('set null');
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

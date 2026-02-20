<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckedByToAuditFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_files', function (Blueprint $table) {
            $table->bigInteger('checked_by')->unsigned()->nullable()->after('date_last_checked');

            $table->foreign('checked_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /** 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_files', function (Blueprint $table) {
            //
        });
    }
}

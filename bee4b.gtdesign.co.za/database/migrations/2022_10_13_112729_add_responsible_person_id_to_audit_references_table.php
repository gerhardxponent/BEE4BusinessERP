<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsiblePersonIdToAuditReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_references', function (Blueprint $table) {
            $table->bigInteger('responsible_person_id')->unsigned()->nullable()->default(null);

            $table->foreign('responsible_person_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_references', function (Blueprint $table) {
            //
        });
    }
}

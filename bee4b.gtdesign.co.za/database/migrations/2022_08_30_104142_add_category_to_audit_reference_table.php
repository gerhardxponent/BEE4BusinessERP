<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToAuditReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_references', function (Blueprint $table) {
            $table->bigInteger('folder_id')->unsigned()->nullable();

            $table->foreign('folder_id')->references('id')->on('audit_reference_categories')->onDelete('cascade');
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

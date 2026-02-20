<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('assigned_to')->unsigned()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('primary_phone');
            $table->string('secondary_phone')->nullable();
            $table->string('email_address');
            $table->string('company_name');
            $table->string('website')->nullable();
            $table->string('industry');
            $table->string('enquiry')->nullable();
            $table->string('source')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}

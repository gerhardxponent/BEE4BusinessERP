<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('priority')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->boolean('completed')->default(0)->nullable();
            $table->bigInteger('phase_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('default_tasks')->onDelete('cascade');
            $table->foreign('phase_id')->references('id')->on('phases')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_tasks');
    }
}

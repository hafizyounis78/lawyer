<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsibleLawyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsible_lawyers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lawyer_id');
            $table->foreign('lawyer_id')->references('emp_id')->on('employees');
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('lawsuits');
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsible_lawyers');
    }
}

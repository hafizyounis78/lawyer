<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedure_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('lawsuits');
            $table->unsignedInteger('prcd_id');
            $table->foreign('prcd_id')->references('id')->on('procedures');
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->unsignedInteger('file_type');
            $table->foreign('file_type')->references('id')->on('upload_file_types');
            $table->string('file_link');
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
        Schema::dropIfExists('procedure_files');
    }
}

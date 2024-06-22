<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLawsuitUploadfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lawsuit_uploadfiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('lawsuits');
            $table->string('file_title');

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
        Schema::dropIfExists('lawsuit_uploadfiles');
    }
}

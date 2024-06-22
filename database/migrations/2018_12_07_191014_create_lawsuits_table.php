<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLawsuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lawsuits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_no', 11);
            $table->integer('file_counter');
            $table->dateTime('open_date');
            $table->unsignedInteger('court_id');//قم المحكمة
            $table->foreign('court_id')->references('id')->on('courts');
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->string('judge', 100);
            $table->unsignedInteger('lawsuit_type');
            $table->foreign('lawsuit_type')->references('id')->on('lawsuit_types');//نوع القضية
            $table->string('suit_type', 150);//نوع الدعوة
            $table->float('lawsuit_value')->nullable();
            $table->float('lawsuit_result')->nullable();
            $table->unsignedInteger('file_status');
            $table->foreign('file_status')->references('id')->on('file_statuses');
            $table->string('prosecution_file_no')->nullable();
            $table->string('court_file_no')->nullable();

            $table->string('appeal_file_no')->nullable();
            $table->string('veto_file_no')->nullable();
            $table->string('executive_file_no')->nullable();
            $table->string('police_file_no')->nullable();
            $table->string('noti_file_no')->nullable();
            $table->dateTime('close_date')->nullable();
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
        Schema::dropIfExists('lawsuits');
    }
}

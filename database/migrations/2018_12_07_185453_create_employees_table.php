<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('emp_id');
            $table->integer('national_id');
            $table->string('name');
            $table->string('mobile',10)->unique();
            $table->string('address');
            $table->string('email')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('image',250)->nullable();
            $table->unsignedInteger('districts_id');
            $table->foreign('districts_id')->references('id')->on('districts');

            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations');

            $table->unsignedInteger('job_title');
            $table->foreign('job_title')->references('id')->on('jobs');
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
        Schema::dropIfExists('employees');
    }
}

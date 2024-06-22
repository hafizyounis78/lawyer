<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpEvalMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_eval_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('emp_id');
            $table->foreign('emp_id')->references('emp_id')->on('employees');
            $table->unsignedInteger('eval_system_id');
            $table->foreign('eval_system_id')->references('id')->on('eval_systems');
            $table->date('eval_date');
            $table->integer('eval_status');
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
        Schema::dropIfExists('emp_eval_masters');
    }
}

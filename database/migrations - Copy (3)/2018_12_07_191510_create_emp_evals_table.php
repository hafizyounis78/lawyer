<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpEvalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_evals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('emp_id');
            $table->foreign('emp_id')->references('emp_id')->on('employees');
            $table->unsignedInteger('eval_rate_id');
            $table->foreign('eval_rate_id')->references('id')->on('eval_rates');
            $table->float('value');
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
        Schema::dropIfExists('emp_evals');
    }
}

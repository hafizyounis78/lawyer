<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpEvalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_eval_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('eval_master_id');
            $table->foreign('eval_master_id')->references('id')->on('emp_eval_masters')->onDelete('cascade');
            $table->unsignedInteger('eval_rate_id');
            $table->foreign('eval_rate_id')->references('id')->on('eval_rates');
            $table->float('value');

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
        Schema::dropIfExists('emp_eval_details');
    }
}

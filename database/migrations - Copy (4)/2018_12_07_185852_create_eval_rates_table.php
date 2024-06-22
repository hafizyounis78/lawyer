<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvalRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eval_rates', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('eval_id');
            $table->unsignedInteger('rate_id');
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->foreign('eval_id')->references('id')->on('eval_systems')->onDelete('cascade');
            $table->foreign('rate_id')->references('id')->on('rates')->onDelete('cascade');
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
        Schema::dropIfExists('eval_rates');
    }
}

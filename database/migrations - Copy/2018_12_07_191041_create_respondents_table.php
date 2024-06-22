<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespondentsTable extends Migration
{
    /**
     * Run the migrations.
     *المدعى عليه
     * @return void
     */
    public function up()
    {

        Schema::create('respondents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('national_id');
            $table->string('name');
            $table->string('mobile',10)->unique();
            $table->string('address');
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->unsignedInteger('districts_id');
            $table->foreign('districts_id')->references('id')->on('districts');
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
        Schema::dropIfExists('respondents');
    }
}

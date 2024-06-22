<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('lawsuits');
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->dateTime('prcd_date');
            $table->string('prcd_text');
           // $table->unsignedInteger('prcd_status');
           // $table->foreign('prcd_status')->references('id')->on('procedure_statuses');
            $table->string('comments')->nullable();
           // $table->boolean('reminder_flg');
        //    $table->boolean('sms_flg');
         //   $table->string('sms_text',500);

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
        Schema::dropIfExists('procedures');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_id'); //FK
            $table->foreign('file_id')->references('id')->on('lawsuits');
            $table->integer('lawsuit_type');//color from lawsuittype_lookups
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->dateTime('reminder_date');
            $table->unsignedInteger('reminder_type'); //FK
            $table->foreign('reminder_type')->references('id')->on('reminder_types');
            $table->unsignedInteger('lawyer_id');
            $table->foreign('lawyer_id')->references('emp_id')->on('employees');
            $table->integer('event_id'); //FK task,procedure,order
            $table->string('event_text', 1000);
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
        Schema::dropIfExists('reminders');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('emp_id')->nullable();
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations');
          //  $table->integer('type');
        //    $table->string('api_token', 150)->unique()->nullable();
            $table->boolean('isActive');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

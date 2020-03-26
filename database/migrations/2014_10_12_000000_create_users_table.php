<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('dni')->nullable();
            $table->string('phone')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('state')->default('registered');
            $table->boolean('access')->default(true);
            $table->string('user');
            $table->string('password');
            $table->string('role');

            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('sponsor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');

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

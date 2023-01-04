<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 30);
            $table->string('password', 250);
            $table->string('rmb_token', 1100);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
        Schema::dropIfExists('messages');
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->timestamp('created_at');
        });
        Schema::dropIfExists('rooms');
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('admin_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->foreign('admin_id')->references('id')->on('users');
        });
        Schema::dropIfExists('room_user');
        Schema::create('room_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('room_id');
            $table->unsignedInteger('user_id');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
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
            $table->id();
            $table->string('username', 60)->unique();
            $table->string('password', 255);
            $table->string('f_name', 255);
            $table->string('m_name', 255)->nullable();
            $table->string('l_name', 255);
            $table->char('gender', 1);
            $table->string('nationality', 100);
            $table->string('email', 255)->unique();
            $table->string('phone', 15)->unique();
            $table->string('address', 255);
            $table->boolean('is_active');
            $table->bigInteger('role_id')->index();
            $table->timestamp('email_verified_at')->nullable();
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

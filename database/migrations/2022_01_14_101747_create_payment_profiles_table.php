<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('payment_name', 255);
            $table->string('client_names', 255);
            $table->string('address_one', 255);
            $table->string('address_two', 255)->nullable();
            $table->string('acc_id', 255);
            $table->bigInteger('user_id')->index()->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('users')->on('id')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_profiles');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('second_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('first_form_id');
            $table->foreign('first_form_id')->references('id')->on('first_forms')->onDelete('cascade');
            $table->string('dob');
            $table->string('phone');
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
        Schema::dropIfExists('second_forms');
    }
};

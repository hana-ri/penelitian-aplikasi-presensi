<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_information', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('nim')->unique();
            $table->string('faculty');
            $table->string('majoring');
            $table->binary('registered_face');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('mdl_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_information');
    }
};

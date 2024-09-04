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
        Schema::create('user_classroom', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('classroom_id');
            $table->foreign('user_id')->references('id')->on('mdl_user')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_classsroom');
    }
};

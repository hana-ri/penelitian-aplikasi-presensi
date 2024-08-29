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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->bigInteger('id', true, false);
            $table->string('code', 255)->unique();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_enrollmen')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};

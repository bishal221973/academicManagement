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
        Schema::create('hostel_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('hostel_id')->constrained('hostels');
            $table->foreignId('room_id')->constrained('rooms');
            $table->string('check_in_date')->nullable();
            $table->string('check_out_date')->nullable();
            $table->string('price')->nullable();
            $table->string('bed_no')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostel_students');
    }
};

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
        Schema::create('hostel_student_features', function (Blueprint $table) {
            $table->id();
           $table->foreignId('hostel_feature_id')->constrained();
           $table->foreignId('hostel_student_id')->constrained();
           $table->string('price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostel_student_features');
    }
};

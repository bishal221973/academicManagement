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
        Schema::create('postal_dispatches', function (Blueprint $table) {
            $table->id();
            $table->string('to_title')->nullable();
            $table->string('from_title')->nullable();
            $table->string('reference')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('date')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postal_dispatches');
    }
};

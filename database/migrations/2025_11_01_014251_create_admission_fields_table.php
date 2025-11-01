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
        Schema::create('admission_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_section_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('position');
            $table->string('size')->default('col-span-3');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_fields');
    }
};

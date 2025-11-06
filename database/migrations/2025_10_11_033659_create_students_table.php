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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('roll_number');
            $table->string('name');
            $table->string('registration_number')->nullable();
            $table->string('registration_date')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('cast')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('national_id')->nullable();

            $table->foreignId('course_id')->constrained()->nullable();
            $table->foreignId('academic_year_id')->constrained()->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id')->references('id')->on('sections');

            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('groups');

            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_education')->nullable();
            $table->string('father_profession')->nullable();

            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_education')->nullable();
            $table->string('mother_profession')->nullable();

            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();

            $table->string('prev_school')->nullable();
            $table->string('prev_class')->nullable();
            $table->string('transfer_certificate')->nullable();

            $table->string('profile')->nullable();
            
            $table->boolean('status')->default(true);
            $table->boolean('is_transfered')->default(false);


            $table->string('hostel_id_number')->nullable();
            $table->string('library_id_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

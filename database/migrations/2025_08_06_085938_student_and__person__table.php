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
        Schema::dropIfExists('Students');
        Schema::dropIfExists('people');
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('Fullname');
            $table->date('date_of_birth')->nullable(true);
            $table->string('phone_number')->nullable(true);
            $table->enum('gender', ['male', 'female', 'unselected'])->default('unselected');
            $table->timestamps();
        });

        Schema::create('Students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('EnrollmentType')->default('Normal-Student');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

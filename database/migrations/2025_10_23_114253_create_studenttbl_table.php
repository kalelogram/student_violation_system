<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('studenttbl', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            // Add auto-increment student_id as primary key FIRST
            $table->id('student_id');
            
            // Student number (from student_db)
            $table->string('student_no', 11);
            
            // Foreign key to violationtbl
            $table->unsignedBigInteger('violation_id')->nullable();
            
            // Student data (fetched from student_db when violation is recorded)
            $table->string('first_name');
            $table->char('middle_initial')->nullable();
            $table->string('last_name');
            $table->string('program');
            $table->integer('year_lvl');
            $table->string('parent_contact_no', 11)->nullable();
            
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('violation_id')
                ->references('violation_id')
                ->on('violationtbl')
                ->onDelete('cascade');
            
            // Unique constraint to prevent duplicate student_no + violation_id combinations
            $table->unique(['student_no', 'violation_id'], 'student_violation_unique');
            
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('studenttbl');
    }
};
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
        Schema::connection('mysql_STUDENT')->create('students', function (Blueprint $table) {
            $table->string('student_no', 11)->primary();
            $table->string('first_name');
            $table->string('middle_initial');
            $table->string('last_name');
            $table->char('sex');
            $table->integer('age');
            $table->string('program');
            $table->string('year_lvl');
            $table->string('parent_contact_no', 11);
            

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

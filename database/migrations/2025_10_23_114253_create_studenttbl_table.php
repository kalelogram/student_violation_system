<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\note;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mysql')->create('studenttbl', function (Blueprint $table) {
            $table->Id('student_no');
            $table->string('first_name');
            $table->string('middle_initial');
            $table->string('last_name');
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
        Schema::dropIfExists('studenttbl');
    }
};

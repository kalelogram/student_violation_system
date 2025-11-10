<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('violationtbl', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('violation_id');
            $table->string('student_no'); // 👈 THIS is important
            $table->string('violation');
            $table->text('description')->nullable();
            $table->string('remarks')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('violationtbl');
    }
};
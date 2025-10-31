<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->table('violationtbl', function (Blueprint $table) {
            $table->string('photo_path')->nullable()->after('remarks');
        });
    }

    public function down()
    {
        Schema::connection('mysql')->table('violationtbl', function (Blueprint $table) {
            $table->dropColumn('photo_path');
        });
    }
};
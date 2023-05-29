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
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->string('local', 3);
            $table->string('oaci', 4)->nullable()->unique();
            $table->string('iata', 3)->nullable();
            $table->string('name');
            $table->unsignedTinyInteger('type');
            $table->decimal('latitude', 16, 14);
            $table->decimal('longitude', 17, 14);
            $table->decimal('elevation', 8, 2);
            $table->unsignedTinyInteger('elevation_uom');
            $table->unsignedTinyInteger('condition');
            $table->unsignedTinyInteger('control');
            $table->unsignedTinyInteger('fir');
            $table->unsignedTinyInteger('use')->nullable();
            $table->unsignedTinyInteger('traffic');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};

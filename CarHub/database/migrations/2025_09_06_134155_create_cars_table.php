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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('marka');
            $table->string('modell');
            $table->integer('evjarat');
            $table->integer('ar');
            $table->integer('km_ora');
            $table->integer('teljesitmeny');
            $table->string('uzemanyag');
            $table->string('valto');
            $table->string('szin');
            $table->string('karosszeria');
            $table->text('leiras')->nullable();
            $table->string('extrak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};

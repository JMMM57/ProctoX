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
        if (!Schema::hasTable('salones')) {
            Schema::create('salones', function (Blueprint $table) {
                $table->id();
                $table->string('codigo')->unique();
                $table->string('edificio');
                $table->integer('capacidad');
                $table->timestamp('created_at')->nullable();
                $table->string('nombre')->nullable();
                $table->string('tipo')->nullable();
                $table->string('estado')->default('activo');
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
            });
        } else {
            Schema::table('salones', function (Blueprint $table) {
                $table->string('nombre')->nullable();
                $table->string('tipo')->nullable();
                $table->string('estado')->default('activo');
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salones');
    }
};

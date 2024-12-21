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
        Schema::create('user_mile_mouvments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_mile_id')->constrained()->onDelete('cascade');
            $table->integer('miles');
            $table->enum('movement', ['in', 'out']);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_mile_mouvments');
    }
};

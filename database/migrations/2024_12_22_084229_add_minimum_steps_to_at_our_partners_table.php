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
        Schema::table('at_our_partners', function (Blueprint $table) {
            $table->integer('minimum_steps');
            $table->integer('current_steps_in_beginning')->after('done');
            $table->integer('current_steps_in_end')->nullable()->after('current_steps_in_beginning');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('at_our_partners', function (Blueprint $table) {
            $table->dropColumn('minimum_steps');
        });
    }
};
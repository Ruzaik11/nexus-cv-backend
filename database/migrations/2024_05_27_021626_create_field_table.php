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
        Schema::create('field', function (Blueprint $table) {
            $table->integer('field_id', true);
            $table->integer('section_id')->index('section_id');
            $table->string('field_name', 255);
            $table->string('field_type', 50);
            $table->integer('field_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field');
    }
};

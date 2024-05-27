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
        Schema::create('cv_field_data', function (Blueprint $table) {
            $table->integer('cv_id');
            $table->integer('field_id')->index('field_id');
            $table->text('field_value')->nullable();

            $table->primary(['cv_id', 'field_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_field_data');
    }
};

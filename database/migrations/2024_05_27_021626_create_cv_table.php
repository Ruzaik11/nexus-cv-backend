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
        Schema::create('cv', function (Blueprint $table) {
            $table->integer('cv_id', true);
            $table->integer('user_id')->index('user_id');
            $table->integer('template_id')->index('template_id');
            $table->string('title', 255)->nullable();
            $table->timestamp('creation_date')->nullable()->useCurrent();
            $table->timestamp('last_updated_date')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv');
    }
};

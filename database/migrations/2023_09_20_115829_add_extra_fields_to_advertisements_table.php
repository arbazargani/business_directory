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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('fullname')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_name');
            $table->json('business_categories');
            $table->json('work_hours')->nullable();
            $table->json('off_days')->nullable();
            $table->string('address')->nullable();
            $table->string('business_number')->nullable();
            $table->json('social_media')->nullable();
            $table->json('business_images')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            //
        });
    }
};

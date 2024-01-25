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
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->longText('meta_description');
            $table->longText('meta_robots');
            $table->foreignIdFor(\App\Models\User::class);
            $table->integer('hidden')->default(0);
            $table->integer('views')->default(0);
            $table->text('cover')->nullable();
            $table->integer('previous_state')->nullable();
            $table->integer('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};

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
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name')->default("Sazzad's Dev.");
            $table->string('name')->default("Sazzad Hossain");
            $table->string('work_details')->default("Full-Stack Developer & AI Solutions Specialist");
            $table->text('description')->nullable();
            $table->string('consultancy_button_text')->nullable()->default("GET FREE CONSULTANCY");
            $table->string('consultancy_button_url')->nullable()->default("#contact");
            $table->string('talk_button_text')->nullable()->default("LET'S TALK");
            $table->string('talk_button_url')->nullable()->default("#contact");
            $table->string('avatar_path')->nullable();
            $table->string('video_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};

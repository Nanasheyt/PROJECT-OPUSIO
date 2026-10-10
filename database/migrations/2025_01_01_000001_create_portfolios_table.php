<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 32)->unique();
            $table->string('full_name', 150);
            $table->string('job_title', 150)->nullable();
            $table->string('email', 150);
            $table->string('phone', 40);
            $table->string('address', 255);
            $table->text('about');
            $table->longText('profile_picture')->nullable(); // stored as data URI so it survives on cloud hosts
            $table->string('template', 20)->default('simple'); // simple | modern | creative
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};

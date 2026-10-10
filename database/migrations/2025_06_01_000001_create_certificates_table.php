<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->cascadeOnDelete();
            $table->longText('image'); // resized photo stored as a data URI so it survives on cloud hosts
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Supabase exposes the public schema over its REST API; keep this table closed (Laravel connects as owner).
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "certificates" ENABLE ROW LEVEL SECURITY');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};

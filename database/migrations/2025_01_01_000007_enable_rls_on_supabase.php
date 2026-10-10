<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Supabase exposes every table in the "public" schema through its REST API.
 * Laravel connects as the table owner (postgres), which bypasses RLS, so enabling
 * RLS (with no public policies) keeps the tables closed to anyone using the anon key.
 */
return new class extends Migration
{
    private array $tables = ['portfolios', 'educations', 'skills', 'projects', 'experiences', 'social_links'];

    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }
        foreach ($this->tables as $table) {
            DB::statement("ALTER TABLE \"{$table}\" ENABLE ROW LEVEL SECURITY");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }
        foreach ($this->tables as $table) {
            DB::statement("ALTER TABLE \"{$table}\" DISABLE ROW LEVEL SECURITY");
        }
    }
};

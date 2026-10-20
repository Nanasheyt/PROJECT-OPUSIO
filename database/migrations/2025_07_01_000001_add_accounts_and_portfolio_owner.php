<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Accounts: every portfolio belongs to a user.
 * A default Laravel install already has "users", "password_reset_tokens" and "sessions";
 * they are only created here when they are missing, so this is safe to run on your existing database.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        if (! Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        // Owner of each portfolio (NULL for portfolios created before accounts existed)
        if (! Schema::hasColumn('portfolios', 'user_id')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
            });
        }

        // Supabase exposes the public schema over its REST API. Keep the account tables (they hold password hashes)
        // closed to the public API key; Laravel connects as the table owner, which bypasses RLS.
        if (DB::getDriverName() === 'pgsql') {
            foreach (['users', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs', 'migrations'] as $table) {
                if (Schema::hasTable($table)) {
                    DB::statement('ALTER TABLE "' . $table . '" ENABLE ROW LEVEL SECURITY');
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('portfolios', 'user_id')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }
    }
};

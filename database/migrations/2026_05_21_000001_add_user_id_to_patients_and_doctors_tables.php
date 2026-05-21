<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Add user_id to patients ────────────────────────────────────────
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->nullOnDelete();
        });

        // ── Add user_id to doctors ─────────────────────────────────────────
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->nullOnDelete();
        });

        // ── Link existing patients to users by matching email ──────────────
        DB::statement('
            UPDATE patients
            SET user_id = (
                SELECT id FROM users
                WHERE users.email = patients.email
                LIMIT 1
            )
            WHERE user_id IS NULL
        ');

        // ── Link existing doctors to users by matching email ───────────────
        DB::statement('
            UPDATE doctors
            SET user_id = (
                SELECT id FROM users
                WHERE users.email = doctors.email
                LIMIT 1
            )
            WHERE user_id IS NULL
        ');
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};

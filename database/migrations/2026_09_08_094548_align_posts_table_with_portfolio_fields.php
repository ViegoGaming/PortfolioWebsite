<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('posts', 'contents') && ! Schema::hasColumn('posts', 'description')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->renameColumn('contents', 'description');
            });
        }

        if (! Schema::hasColumn('posts', 'images')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->json('images')->nullable()->after('description');
            });
        }

        if (! Schema::hasColumn('posts', 'published_at')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->timestamp('published_at')->nullable()->index()->after('images');
            });
        }

        DB::table('posts')
            ->whereNull('published_at')
            ->update(['published_at' => DB::raw('created_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This compatibility migration preserves existing project data on rollback.
    }
};

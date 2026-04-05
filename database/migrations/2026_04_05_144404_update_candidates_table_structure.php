<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DB::statement to force data type conversion with 'USING'
        DB::statement('ALTER TABLE candidates ALTER COLUMN recommendation TYPE JSON USING recommendation::json');

        Schema::table('candidates', function (Blueprint $table) {
            // After the data type changes, then set NOT NULL
            $table->json('recommendation')->nullable(false)->change();
            $table->json('cv_recommendation')->nullable()->after('recommendation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->text('recommendation')->change();
            $table->dropColumn('cv_recommendation');
        });
    }
};

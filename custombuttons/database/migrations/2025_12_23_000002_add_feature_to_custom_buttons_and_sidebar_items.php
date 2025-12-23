<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('custom_buttons', function (Blueprint $table) {
            $table->string('feature')->nullable()->after('server_id');
        });

        Schema::table('custom_sidebar_items', function (Blueprint $table) {
            $table->string('feature')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('custom_buttons', function (Blueprint $table) {
            $table->dropColumn('feature');
        });

        Schema::table('custom_sidebar_items', function (Blueprint $table) {
            $table->dropColumn('feature');
        });
    }
};

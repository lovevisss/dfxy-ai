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
        Schema::table('ais', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(100)->index()->after('img');
        });

        DB::table('ais')->where('name', '教务AI小助手')->update(['sort_order' => 1]);
        DB::table('ais')->where('name', '财务报销小助手')->update(['sort_order' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ais', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
            $table->dropColumn('sort_order');
        });
    }
};

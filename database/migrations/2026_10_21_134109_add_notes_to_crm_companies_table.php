<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('crm.table_prefix', 'crm_').'companies', function (Blueprint $table): void {
            $table->text('notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table(config('crm.table_prefix', 'crm_').'companies', function (Blueprint $table): void {
            $table->dropColumn('notes');
        });
    }
};

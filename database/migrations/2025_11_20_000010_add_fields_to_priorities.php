<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('priorities', function (Blueprint $table) {
            $table->integer('sla_hours')->nullable()->after('name');
            $table->decimal('bonus_cap', 5, 2)->default(1.50)->after('sla_hours');
            $table->decimal('early_cap', 5, 2)->default(0.30)->after('bonus_cap');
            $table->boolean('is_time_sensitive')->default(true)->after('early_cap');
        });
    }

    public function down() {
        Schema::table('priorities', function (Blueprint $table) {
            $table->dropColumn(['sla_hours','bonus_cap','early_cap','is_time_sensitive']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetricsToUnitPerformanceScores extends Migration
{
    public function up()
    {
        Schema::table('unit_performance_scores', function (Blueprint $table) {
            $table->integer('tickets_received')->default(0)->after('period');
            // if tickets_solved doesn't exist yet:
            if (! Schema::hasColumn('unit_performance_scores', 'tickets_solved')) {
                $table->integer('tickets_solved')->default(0)->after('tickets_received');
            }
            $table->float('solved_ratio', 8, 4)->default(0)->after('tickets_solved');
            $table->index(['period', 'unit_id']);
        });
    }

    public function down()
    {
        Schema::table('unit_performance_scores', function (Blueprint $table) {
            $table->dropIndex(['period', 'unit_id']);
            $table->dropColumn(['tickets_received','tickets_solved','solved_ratio']);
        });
    }
}
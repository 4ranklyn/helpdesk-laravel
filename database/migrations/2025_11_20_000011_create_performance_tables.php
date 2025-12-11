<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('staff_performance_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->integer('tickets_solved')->default(0);
            $table->decimal('avg_sla_score', 8, 4)->default(0);
            $table->decimal('avg_rating', 8, 4)->default(0);
            $table->decimal('saw_score', 8, 6)->default(0);
            $table->integer('rank')->nullable();
            $table->string('period')->nullable(); // format YYYY-MM
            $table->timestamps();
            // optional FK: 
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('unit_performance_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->integer('tickets_solved')->default(0);
            $table->decimal('avg_sla_score', 8, 4)->default(0);
            $table->decimal('avg_rating', 8, 4)->default(0);
            $table->decimal('saw_score', 8, 6)->default(0);
            $table->integer('rank')->nullable();
            $table->string('period')->nullable();
            $table->timestamps();
            // optional FK
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('unit_performance_scores');
        Schema::dropIfExists('staff_performance_scores');
    }
};

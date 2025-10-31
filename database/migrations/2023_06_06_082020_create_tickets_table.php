<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('priority_id')->index('tickets_priority_id_index');
            $table->unsignedBigInteger('unit_id')->index('tickets_unit_id_index');
            $table->unsignedBigInteger('owner_id')->index('tickets_owner_id_index');
            $table->unsignedBigInteger('problem_category_id')->index('tickets_problem_category_id_index');
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('ticket_statuses_id')->index('tickets_ticket_statuses_id_index');
            $table->unsignedBigInteger('responsible_id')->nullable()->index('tickets_responsible_id_index');
            $table->timestamps();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('solved_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};

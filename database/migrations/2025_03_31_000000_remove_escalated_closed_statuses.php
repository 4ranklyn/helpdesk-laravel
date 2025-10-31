<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Update any tickets with ESCALATED (5) or CLOSED (8) status to RESOLVED (6)
        DB::table('tickets')
            ->whereIn('ticket_statuses_id', [5, 8])
            ->update(['ticket_statuses_id' => 6]);

        // Remove the statuses from the database
        DB::table('ticket_statuses')
            ->whereIn('id', [5, 8])
            ->delete();
    }

    public function down()
    {
        // This is a destructive change, so the down method will not restore the statuses
        // as we don't have the original status names. Manual intervention would be needed.
    }
};

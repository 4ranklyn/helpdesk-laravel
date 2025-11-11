<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateTicketStatusesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update ticket statuses to use the correct constants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating ticket statuses...');
        
        $statuses = [
            'Open' => TicketStatus::OPEN,
            'Assigned' => TicketStatus::ASSIGNED,
            'In Progress' => TicketStatus::IN_PROGRESS,
            'On Hold' => TicketStatus::ON_HOLD,
            'Pending Customer Response' => TicketStatus::PENDING_CUSTOMER_RESPONSE,
            'Resolved' => TicketStatus::RESOLVED,
        ];
        
        foreach ($statuses as $name => $id) {
            $count = DB::table('ticket_statuses')
                ->where('name', $name)
                ->update(['id' => $id]);
                
            $this->info("Updated status '" . $name . "' to ID: " . $id);
        }
        
        $this->info('Ticket statuses updated successfully!');
    }
}

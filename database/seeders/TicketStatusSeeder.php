<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['id' => TicketStatus::OPEN, 'name' => 'Open'],
            ['id' => TicketStatus::ASSIGNED, 'name' => 'Assigned'],
            ['id' => TicketStatus::IN_PROGRESS, 'name' => 'In Progress'],
            ['id' => TicketStatus::ON_HOLD, 'name' => 'On Hold'],
            ['id' => TicketStatus::PENDING_CUSTOMER_RESPONSE, 'name' => 'Pending Customer Response'],
            ['id' => TicketStatus::RESOLVED, 'name' => 'Resolved']
        ];

        foreach ($statuses as $status) {
            TicketStatus::updateOrCreate(
                ['id' => $status['id']],
                ['name' => $status['name']]
            );
        }
    }
}

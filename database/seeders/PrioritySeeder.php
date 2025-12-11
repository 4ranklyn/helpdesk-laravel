<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Priority::create(['id' => Priority::CRITICAL, 'name' => 'Critical/Urgent', 'sla_hours'=>4,'bonus_cap'=>1.3,'early_cap'=>0.5,'is_time_sensitive'=>true]);
        Priority::create(['id' => Priority::HIGH, 'name' => 'High','sla_hours'=>8,'bonus_cap'=>1.3,'early_cap'=>0.5,'is_time_sensitive'=>true]);
        Priority::create(['id' => Priority::MEDIUM, 'name' => 'Medium','sla_hours'=>24,'bonus_cap'=>1.3,'early_cap'=>0.5,'is_time_sensitive'=>true]);
        Priority::create(['id' => Priority::LOW, 'name' => 'Low','sla_hours'=>48,'bonus_cap'=>1.3,'early_cap'=>0.5,'is_time_sensitive'=>true]);
        Priority::create(['id' => Priority::ENHANCEMENT, 'name' => 'Enhancement/Feature Request','sla_hours'=>168,'bonus_cap'=>1.0,'early_cap'=>0.5,'is_time_sensitive'=>false]);
    }
}

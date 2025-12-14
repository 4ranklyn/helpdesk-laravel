<?php
use App\Models\Unit;
use App\Models\ProblemCategory;

$unit = Unit::where('name', 'IT')->first();
if ($unit) {
    echo "Unit found: " . $unit->name . " (ID: " . $unit->id . ")\n";
    $categories = $unit->problemCategories;
    echo "Problem Categories count: " . $categories->count() . "\n";
    foreach ($categories as $cat) {
        echo "- " . $cat->name . "\n";
    }
} else {
    echo "Unit 'IT' not found.\n";
}

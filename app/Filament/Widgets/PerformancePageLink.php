<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class PerformancePageLink extends Widget
{
    protected static string $view = 'filament.widgets.performance-page-link';
    protected static ?int $sort = 5; // Put this at the very bottom
    protected int | string | array $columnSpan = 'full';
}
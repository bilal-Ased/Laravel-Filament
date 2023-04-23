<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\LineChartWidget;

class TaskChart extends LineChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {

        return [
            'datasets' => [
                [
                    'label' => 'Tasks created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}

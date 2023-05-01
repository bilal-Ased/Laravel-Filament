<?php

namespace App\Filament\Widgets;
use App\Models\Task;
use App\Models\Ticket;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
 
class TaskChart extends LineChartWidget
{
    protected static ?string $heading = 'All Tickets';

    protected function getData(): array
    {

       
        $data = Trend::model(Ticket::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Tickets',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }
}

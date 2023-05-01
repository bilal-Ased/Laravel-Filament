<?php

namespace App\Filament\Widgets;
use App\Models\leads;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\BarChartWidget;

class TasksLeadsChart extends BarChartWidget
{
    protected static ?string $heading = 'All Leads Chart';

    protected function getData(): array
    {
          
        $data = Trend::model(leads::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Leads',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }
    
}

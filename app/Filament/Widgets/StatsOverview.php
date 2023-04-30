<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{

    protected static ?string $pollingInterval = '10s';

    protected function getCards(): array
    {
        return [
            Card::make('All Users',User::all()->count())
            ->description('32k increase')
            ->descriptionIcon('heroicon-s-trending-up'),
        Card::make('All Tickets',Ticket::all()->count())
            ->description('7% increase')
            ->descriptionIcon('heroicon-s-trending-down'),
        Card::make('Number of Customers', Customer::all()->count())
            ->description('3% increase')
            ->descriptionIcon('heroicon-s-trending-up'),

        ];
    }
}

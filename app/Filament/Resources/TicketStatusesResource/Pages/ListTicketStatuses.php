<?php

namespace App\Filament\Resources\TicketStatusesResource\Pages;

use App\Filament\Resources\TicketStatusesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTicketStatuses extends ListRecords
{
    protected static string $resource = TicketStatusesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

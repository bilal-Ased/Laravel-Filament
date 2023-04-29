<?php

namespace App\Filament\Resources\TicketStatusesResource\Pages;

use App\Filament\Resources\TicketStatusesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketStatuses extends EditRecord
{
    protected static string $resource = TicketStatusesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

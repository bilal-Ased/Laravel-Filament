<?php

namespace App\Filament\Resources\LeadStageResource\Pages;

use App\Filament\Resources\LeadStageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeadStage extends EditRecord
{
    protected static string $resource = LeadStageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

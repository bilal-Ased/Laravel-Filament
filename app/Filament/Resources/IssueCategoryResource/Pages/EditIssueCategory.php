<?php

namespace App\Filament\Resources\IssueCategoryResource\Pages;

use App\Filament\Resources\IssueCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIssueCategory extends EditRecord
{
    protected static string $resource = IssueCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

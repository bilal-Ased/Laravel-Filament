<?php

namespace App\Filament\Resources\IssueSourcesResource\Pages;

use App\Filament\Resources\IssueSourcesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIssueSources extends ListRecords
{
    protected static string $resource = IssueSourcesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

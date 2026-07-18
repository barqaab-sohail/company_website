<?php

namespace App\Filament\Resources\AboutProfiles\Pages;

use App\Filament\Resources\AboutProfiles\AboutProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAboutProfiles extends ListRecords
{
    protected static string $resource = AboutProfileResource::class;

    protected function getHeaderActions(): array
    {
        return AboutProfileResource::canCreate() ? [CreateAction::make()] : [];
    }
}

<?php

namespace App\Filament\Resources\ManagementMembers\Pages;

use App\Filament\Resources\ManagementMembers\ManagementMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListManagementMembers extends ListRecords
{
    protected static string $resource = ManagementMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

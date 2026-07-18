<?php

namespace App\Filament\Resources\CoreStaffMembers\Pages;

use App\Filament\Resources\CoreStaffMembers\CoreStaffMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCoreStaffMembers extends ListRecords
{
    protected static string $resource = CoreStaffMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

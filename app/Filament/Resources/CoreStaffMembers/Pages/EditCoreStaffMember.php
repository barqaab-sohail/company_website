<?php

namespace App\Filament\Resources\CoreStaffMembers\Pages;

use App\Filament\Resources\CoreStaffMembers\CoreStaffMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCoreStaffMember extends EditRecord
{
    protected static string $resource = CoreStaffMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}

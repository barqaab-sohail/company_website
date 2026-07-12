<?php

namespace App\Filament\Resources\ManagementMembers\Pages;

use App\Filament\Resources\ManagementMembers\ManagementMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditManagementMember extends EditRecord
{
    protected static string $resource = ManagementMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

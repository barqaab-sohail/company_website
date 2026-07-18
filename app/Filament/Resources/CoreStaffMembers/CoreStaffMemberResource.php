<?php

namespace App\Filament\Resources\CoreStaffMembers;

use App\Filament\Resources\CoreStaffMembers\Pages\CreateCoreStaffMember;
use App\Filament\Resources\CoreStaffMembers\Pages\EditCoreStaffMember;
use App\Filament\Resources\CoreStaffMembers\Pages\ListCoreStaffMembers;
use App\Filament\Resources\CoreStaffMembers\Schemas\CoreStaffMemberForm;
use App\Filament\Resources\CoreStaffMembers\Tables\CoreStaffMembersTable;
use App\Models\CoreStaffMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CoreStaffMemberResource extends Resource
{
    protected static ?string $model = CoreStaffMember::class;

    protected static ?string $navigationLabel = 'Core Staff';

    protected static ?string $modelLabel = 'core staff member';

    protected static ?string $pluralModelLabel = 'Core Staff';

    protected static ?string $slug = 'core-staff';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    public static function form(Schema $schema): Schema
    {
        return CoreStaffMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoreStaffMembersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCoreStaffMembers::route('/'),
            'create' => CreateCoreStaffMember::route('/create'),
            'edit' => EditCoreStaffMember::route('/{record}/edit'),
        ];
    }
}

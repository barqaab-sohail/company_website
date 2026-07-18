<?php

namespace App\Filament\Resources\ManagementMembers;

use App\Filament\Resources\ManagementMembers\Pages\CreateManagementMember;
use App\Filament\Resources\ManagementMembers\Pages\EditManagementMember;
use App\Filament\Resources\ManagementMembers\Pages\ListManagementMembers;
use App\Filament\Resources\ManagementMembers\Schemas\ManagementMemberForm;
use App\Filament\Resources\ManagementMembers\Tables\ManagementMembersTable;
use App\Models\ManagementMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ManagementMemberResource extends Resource
{
    protected static ?string $model = ManagementMember::class;

    protected static ?string $navigationLabel = 'Management';

    protected static ?string $modelLabel = 'management member';

    protected static ?string $pluralModelLabel = 'Management';

    protected static ?string $slug = 'management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    public static function form(Schema $schema): Schema
    {
        return ManagementMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ManagementMembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListManagementMembers::route('/'),
            'create' => CreateManagementMember::route('/create'),
            'edit' => EditManagementMember::route('/{record}/edit'),
        ];
    }
}

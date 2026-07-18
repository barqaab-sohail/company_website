<?php

namespace App\Filament\Resources\AboutProfiles;

use App\Filament\Resources\AboutProfiles\Pages\CreateAboutProfile;
use App\Filament\Resources\AboutProfiles\Pages\EditAboutClients;
use App\Filament\Resources\AboutProfiles\Pages\EditAboutExpertise;
use App\Filament\Resources\AboutProfiles\Pages\EditAboutOrganization;
use App\Filament\Resources\AboutProfiles\Pages\EditAboutProfile;
use App\Filament\Resources\AboutProfiles\Pages\EditAboutRegistration;
use App\Filament\Resources\AboutProfiles\Pages\ListAboutProfiles;
use App\Filament\Resources\AboutProfiles\Schemas\AboutProfileForm;
use App\Filament\Resources\AboutProfiles\Tables\AboutProfilesTable;
use App\Models\AboutProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AboutProfileResource extends Resource
{
    protected static ?string $model = AboutProfile::class;

    protected static ?string $navigationLabel = 'About Us';

    protected static ?string $modelLabel = 'About Us';

    protected static ?string $pluralModelLabel = 'About Us';

    protected static ?string $slug = 'about-us';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    public static function canCreate(): bool
    {
        return ! AboutProfile::query()->exists();
    }

    public static function form(Schema $schema): Schema
    {
        return AboutProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutProfilesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAboutProfiles::route('/'),
            'create' => CreateAboutProfile::route('/create'),
            'overview' => EditAboutProfile::route('/{record}/overview'),
            'organization' => EditAboutOrganization::route('/{record}/organization-chart'),
            'registration' => EditAboutRegistration::route('/{record}/registration'),
            'clients' => EditAboutClients::route('/{record}/clients'),
            'expertise' => EditAboutExpertise::route('/{record}/expertise'),
        ];
    }
}

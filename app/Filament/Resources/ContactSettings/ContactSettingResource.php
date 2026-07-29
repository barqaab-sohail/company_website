<?php

namespace App\Filament\Resources\ContactSettings;

use App\Filament\Resources\ContactSettings\Pages\EditContactSetting;
use App\Filament\Resources\ContactSettings\Pages\ListContactSettings;
use App\Filament\Resources\ContactSettings\Schemas\ContactSettingForm;
use App\Filament\Resources\ContactSettings\Tables\ContactSettingsTable;
use App\Models\ContactSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactSettingResource extends Resource
{
    protected static ?string $model = ContactSetting::class;
    protected static ?string $navigationLabel = 'Contact Us';
    protected static ?string $modelLabel = 'Contact Us settings';
    protected static ?string $pluralModelLabel = 'Contact Us';
    protected static ?string $slug = 'contact-us';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    public static function shouldRegisterNavigation(): bool { return false; }
    public static function canCreate(): bool { return false; }
    public static function form(Schema $schema): Schema { return ContactSettingForm::configure($schema); }
    public static function table(Table $table): Table { return ContactSettingsTable::configure($table); }

    public static function getPages(): array
    {
        return [
            'index' => ListContactSettings::route('/'),
            'edit' => EditContactSetting::route('/{record}/edit'),
        ];
    }
}

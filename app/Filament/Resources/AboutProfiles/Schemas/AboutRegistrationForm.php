<?php

namespace App\Filament\Resources\AboutProfiles\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Registrations')->description('Use the Registrations table in the About Us menu to Add registration records or edit existing entries.')->schema([])->columnSpanFull(),
        ]);
    }
}

<?php

namespace App\Filament\Resources\AboutProfiles\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutClientsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Client section introduction')->description('Use the Clients table in the About Us menu to Add client records or edit existing entries.')->schema([
                Textarea::make('clients_intro')->label('Introduction')->rows(3)->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }
}

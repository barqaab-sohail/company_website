<?php

namespace App\Filament\Resources\AboutProfiles\Schemas;

use Filament\Forms\Components\{Repeater, Textarea, TextInput};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Registration')->schema([
                Repeater::make('registrations')->schema([
                    TextInput::make('title')->required()->columnSpanFull(),
                    TextInput::make('number')->label('Registration / certification number'),
                    Textarea::make('details')->rows(2),
                ])->columns(2)->addActionLabel('Add registration')->reorderable()->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }
}

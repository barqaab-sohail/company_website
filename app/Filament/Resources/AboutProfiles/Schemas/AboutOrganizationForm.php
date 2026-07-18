<?php

namespace App\Filament\Resources\AboutProfiles\Schemas;

use Filament\Forms\Components\{Repeater, Textarea, TextInput};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutOrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Organization Chart')->schema([
                TextInput::make('organization_heading')->required()->columnSpanFull(),
                Textarea::make('organization_intro')->rows(3)->columnSpanFull(),
                Repeater::make('organization_units')->schema([
                    TextInput::make('title')->required(),
                    Textarea::make('details')->label('Departments / responsibilities')->rows(4)->helperText('Enter one item per line')->required(),
                ])->columns(2)->addActionLabel('Add organization unit')->reorderable()->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }
}

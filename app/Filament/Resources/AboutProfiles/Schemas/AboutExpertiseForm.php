<?php

namespace App\Filament\Resources\AboutProfiles\Schemas;

use Filament\Forms\Components\{RichEditor, TextInput};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutExpertiseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Expertise')->schema([
                TextInput::make('expertise_heading')->required()->columnSpanFull(),
                RichEditor::make('expertise_body')->required()->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }
}

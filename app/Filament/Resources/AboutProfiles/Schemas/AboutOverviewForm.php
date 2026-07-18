<?php

namespace App\Filament\Resources\AboutProfiles\Schemas;

use Filament\Forms\Components\{Repeater, RichEditor, Textarea, TextInput};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutOverviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Overview')->schema([
                TextInput::make('title')->required(),
                TextInput::make('eyebrow')->label('Header label'),
                Textarea::make('hero_text')->label('Introduction')->rows(5)->required()->columnSpanFull(),
                TextInput::make('overview_heading')->required()->columnSpanFull(),
                RichEditor::make('overview_body')->required()->columnSpanFull(),
                Repeater::make('highlights')->schema([
                    TextInput::make('value')->required(),
                    TextInput::make('label')->required(),
                ])->columns(2)->addActionLabel('Add highlight')->columnSpanFull(),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}

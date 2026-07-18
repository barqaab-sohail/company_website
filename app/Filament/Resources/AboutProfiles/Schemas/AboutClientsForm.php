<?php

namespace App\Filament\Resources\AboutProfiles\Schemas;

use Filament\Forms\Components\{FileUpload, Repeater, Textarea, TextInput};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutClientsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Our Clients')->schema([
                Textarea::make('clients_intro')->label('Introduction')->rows(3)->columnSpanFull(),
                Repeater::make('clients')->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('website')->url(),
                    FileUpload::make('logo')->image()->disk('public')->directory('about/clients')->maxSize(5120)->imagePreviewHeight('100')->columnSpanFull(),
                ])->columns(2)->addActionLabel('Add client')->reorderable()->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }
}

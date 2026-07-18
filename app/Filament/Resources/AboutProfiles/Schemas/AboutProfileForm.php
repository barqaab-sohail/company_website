<?php

namespace App\Filament\Resources\AboutProfiles\Schemas;

use Filament\Forms\Components\{FileUpload, Repeater, RichEditor, Textarea, TextInput};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutProfileForm
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

            Section::make('Organization Chart')->schema([
                TextInput::make('organization_heading')->required()->columnSpanFull(),
                Textarea::make('organization_intro')->rows(3)->columnSpanFull(),
                Repeater::make('organization_units')->schema([
                    TextInput::make('title')->required(),
                    Textarea::make('details')->label('Departments / responsibilities')->rows(4)->helperText('Enter one item per line')->required(),
                ])->columns(2)->addActionLabel('Add organization unit')->reorderable()->columnSpanFull(),
            ])->columnSpanFull(),

            Section::make('Registration')->schema([
                Repeater::make('registrations')->schema([
                    TextInput::make('title')->required()->columnSpanFull(),
                    TextInput::make('number')->label('Registration / certification number'),
                    Textarea::make('details')->rows(2),
                ])->columns(2)->addActionLabel('Add registration')->reorderable()->columnSpanFull(),
            ])->columnSpanFull(),

            Section::make('Our Clients')->schema([
                Textarea::make('clients_intro')->label('Introduction')->rows(3)->columnSpanFull(),
                Repeater::make('clients')->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('website')->url(),
                    FileUpload::make('logo')->image()->disk('public')->directory('about/clients')->maxSize(5120)->imagePreviewHeight('100')->columnSpanFull(),
                ])->columns(2)->addActionLabel('Add client')->reorderable()->columnSpanFull(),
            ])->columnSpanFull(),

            Section::make('Expertise')->schema([
                TextInput::make('expertise_heading')->required()->columnSpanFull(),
                RichEditor::make('expertise_body')->required()->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }
}

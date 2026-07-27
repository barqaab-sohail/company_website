<?php

namespace App\Filament\Resources\Registrations\Schemas;

use App\Models\AboutProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Registration details')->schema([
                Hidden::make('about_profile_id')->default(fn () => AboutProfile::query()->value('id')),
                TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
                TextInput::make('number')->label('Registration / certification number')->maxLength(255),
                TextInput::make('sort_order')->label('Display order')->numeric()->default(0)->minValue(0),
                Textarea::make('details')->rows(4)->columnSpanFull(),
                FileUpload::make('document')->label('Registration image')->image()->disk('public')->directory('about/registrations')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(10240)->openable()->downloadable()->required(fn (string $operation): bool => $operation === 'create')->helperText('Required. Upload a JPG, PNG, or WebP image up to 10 MB. PDF files are not allowed.')->columnSpanFull(),
                Toggle::make('show_document')->label('Allow full-size image view on click')->helperText('When disabled, the image remains visible but cannot be opened full-size on the website.')->default(true),
                Toggle::make('is_active')->label('Show on website')->default(true),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}

<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Models\AboutProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Client details')->schema([
                Hidden::make('about_profile_id')->default(fn () => AboutProfile::query()->value('id')),
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('website')->url()->placeholder('https://example.com')->maxLength(255),
                FileUpload::make('logo')->image()->imageResizeMode('contain')->imageResizeTargetWidth('1200')->imageResizeTargetHeight('800')->imageEditor()->disk('public')->directory('about/clients')->maxSize(5120)->helperText('Upload a transparent PNG or WebP logo; oversized images are reduced automatically.'),
                TextInput::make('sort_order')->numeric()->default(0)->minValue(0),
                Toggle::make('is_active')->label('Show on website')->default(true),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}

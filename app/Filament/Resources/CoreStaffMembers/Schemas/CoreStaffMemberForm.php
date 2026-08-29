<?php

namespace App\Filament\Resources\CoreStaffMembers\Schemas;

use Filament\Forms\Components\{FileUpload, Textarea, TextInput, Toggle};
use Filament\Schemas\Schema;

class CoreStaffMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('designation')->required(),
            FileUpload::make('photo')->label('Professional photograph')->image()->imageResizeMode('cover')->imageResizeTargetWidth('1000')->imageResizeTargetHeight('1000')->imageEditor()->disk('public')->directory('core-staff')->maxSize(10240)->helperText('Use a clear, front-facing portrait. Images are resized to 1000 × 1000 pixels.'),
            Textarea::make('qualifications')->rows(5)->helperText('Enter one qualification per line')->columnSpanFull(),
            TextInput::make('years_experience')->label('Years of experience')->placeholder('e.g. Over 25 years'),
            Textarea::make('expertise_summary')->label('Short expertise summary')->rows(4)->maxLength(500)->columnSpanFull(),
            TextInput::make('sort_order')->numeric()->default(0),
            Toggle::make('is_active')->default(true),
        ]);
    }
}

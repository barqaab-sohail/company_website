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
            FileUpload::make('photo')->label('Professional photograph')->image()->imageEditor()->disk('public')->directory('core-staff')->maxSize(10240)->helperText('Use a clear, front-facing portrait. A square image of at least 600 × 600 pixels is recommended.'),
            Textarea::make('qualifications')->rows(5)->helperText('Enter one qualification per line')->columnSpanFull(),
            TextInput::make('years_experience')->label('Years of experience')->placeholder('e.g. Over 25 years'),
            Textarea::make('expertise_summary')->label('Short expertise summary')->rows(4)->maxLength(500)->columnSpanFull(),
            TextInput::make('sort_order')->numeric()->default(0),
            Toggle::make('is_active')->default(true),
        ]);
    }
}

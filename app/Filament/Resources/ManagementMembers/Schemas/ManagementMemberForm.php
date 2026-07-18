<?php

namespace App\Filament\Resources\ManagementMembers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\{FileUpload, RichEditor, Textarea, TextInput, Toggle};

class ManagementMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(), TextInput::make('designation')->required(), FileUpload::make('photo')->label('Professional photograph')->image()->imageEditor()->disk('public')->directory('management')->maxSize(10240)->helperText('Use a clear, front-facing portrait. A square image of at least 600 × 600 pixels is recommended.'),
                Textarea::make('qualifications')->rows(5)->helperText('Enter one qualification per line')->columnSpanFull(),
                RichEditor::make('biography')->columnSpanFull(),
                TextInput::make('sort_order')->numeric()->default(0), Toggle::make('is_active')->default(true),
            ]);
    }
}

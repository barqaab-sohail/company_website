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
                TextInput::make('name')->required(), TextInput::make('designation')->required(), FileUpload::make('photo')->label('Professional photograph')->image()->imageResizeMode('cover')->imageResizeTargetWidth('1000')->imageResizeTargetHeight('1000')->imageEditor()->disk('public')->directory('management')->maxSize(10240)->helperText('Use a clear, front-facing portrait. Images are resized to 1000 × 1000 pixels.'),
                Textarea::make('qualifications')->rows(5)->helperText('Enter one qualification per line')->columnSpanFull(),
                RichEditor::make('biography')->columnSpanFull(),
                TextInput::make('sort_order')->numeric()->default(0), Toggle::make('is_active')->default(true),
            ]);
    }
}

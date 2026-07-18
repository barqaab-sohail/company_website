<?php

namespace App\Filament\Resources\HomeSlides\Schemas;

use Filament\Forms\Components\{FileUpload, TextInput, Toggle};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomeSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Home Page Slide')
                ->description('Upload the project photograph and enter the project name displayed on the homepage slideshow.')
                ->schema([
                    TextInput::make('project_name')->label('Project Name')->required()->maxLength(255)->columnSpanFull(),
                    FileUpload::make('image_path')
                        ->label('Project Picture')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('home-slides')
                        ->maxSize(10240)
                        ->imagePreviewHeight('280')
                        ->helperText('Use a wide landscape image. Recommended size: 1920 × 1080 pixels.')
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('project_url')
                        ->label('Project Link')
                        ->url()
                        ->placeholder('https://...')
                        ->helperText('Optional: clicking the project name will open this link.')
                        ->columnSpanFull(),
                    TextInput::make('sort_order')->numeric()->default(0)->minValue(0),
                    Toggle::make('is_active')->label('Show on Home Page')->default(true),
                ])->columns(2)->columnSpanFull(),
        ]);
    }
}

<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\{DateTimePicker, FileUpload, RichEditor, Select, Textarea, TextInput, Toggle};
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        $isContactPage = fn (?Page $record): bool => in_array($record?->slug, ['contact', 'contact-us'], true);

        return $schema
            ->components([
                TextInput::make('title')->required()->live(onBlur:true)->afterStateUpdated(fn($state,$set)=>$set('slug',Str::slug($state))), TextInput::make('slug')->required()->unique(ignoreRecord:true),
                Textarea::make('excerpt')->columnSpanFull()->hidden($isContactPage),
                RichEditor::make('body')->columnSpanFull()->hidden($isContactPage),
                FileUpload::make('featured_image')->image()->imageResizeMode('contain')->imageResizeTargetWidth('1920')->imageResizeTargetHeight('1440')->disk('public')->directory('pages')->maxSize(10240)->hidden($isContactPage),
                Select::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])->default('published')->required(), DateTimePicker::make('published_at'), TextInput::make('sort_order')->numeric()->default(0),
                Section::make('Search engine optimization')
                    ->description('Optional search and social-sharing settings. Sensible defaults are used when fields are empty.')
                    ->schema([
                        TextInput::make('meta.seo_title')->label('SEO title')->maxLength(60)->helperText('Recommended: 50–60 characters.'),
                        TextInput::make('meta.canonical_url')->label('Canonical URL')->url()->maxLength(500),
                        Textarea::make('meta.seo_description')->label('Meta description')->rows(3)->maxLength(160)->columnSpanFull(),
                        FileUpload::make('meta.social_image')->label('Social sharing image')->image()->disk('public')->directory('seo')->maxSize(5120),
                        Toggle::make('meta.noindex')->label('Hide from search engines'),
                    ])->columns(2)->columnSpanFull()->hidden($isContactPage),
                Section::make('Contact page content')
                    ->description('Manage each heading and Head Office detail shown on the public Contact Us page.')
                    ->schema([
                        TextInput::make('email_heading')->label('Form heading')->required()->maxLength(255),
                        TextInput::make('office_heading')->label('Office heading')->required()->maxLength(255),
                        TextInput::make('company_name')->required()->maxLength(255)->columnSpanFull(),
                        Textarea::make('address')->rows(3)->columnSpanFull(),
                        TextInput::make('phone')->tel()->maxLength(255),
                        TextInput::make('fax')->tel()->maxLength(255),
                        TextInput::make('public_email')->label('Public email')->email()->maxLength(255),
                        TextInput::make('notification_email')
                            ->label('Inquiry forwarding email')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('contact@barqaab.com')
                            ->helperText('Leave empty to disable forwarding. Your server mail settings must be configured for delivery.'),
                        FileUpload::make('logo')
                            ->label('Head Office logo')
                            ->image()
                            ->disk('public')
                            ->directory('contact')
                            ->maxSize(5120),
                        Textarea::make('map_embed_url')
                            ->label('Google Maps embed URL')
                            ->rows(3)
                            ->rules(['nullable', 'url'])
                            ->columnSpanFull()
                            ->helperText('Use the URL from Google Maps “Embed a map”, beginning with https://.'),
                    ])
                    ->columns(2)
                    ->visible($isContactPage)
                    ->columnSpanFull(),
            ]);
    }
}

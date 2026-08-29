<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\{DateTimePicker, FileUpload, Hidden, Repeater, RichEditor, Select, Textarea, TextInput, Toggle};
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Project Details')->schema([
                    TextInput::make('title')->required()->live(onBlur:true)->afterStateUpdated(fn($state,$set)=>$set('slug',Str::slug($state))),
                    TextInput::make('slug')->required()->unique(ignoreRecord:true),
                    Select::make('project_category_id')->label('Category')->relationship('projectCategory', 'name', fn ($query) => $query->orderBy('sort_order')->orderBy('name'))->searchable()->preload()->required(),
                    Textarea::make('subtitle')->columnSpanFull(),
                    RichEditor::make('body')
                        ->label('Project Detail')
                        ->helperText('Enter text only. Add all project pictures in the separate Project Pictures section below.')
                        ->toolbarButtons([
                            ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                            ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                            ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                            ['table'],
                            ['undo', 'redo'],
                        ])
                        ->columnSpanFull(),
                    Textarea::make('scope_of_project')->label('Scope of the Project')->rows(7)->columnSpanFull(),
                    Textarea::make('scope_of_services')->label('Scope of Services')->rows(7)->columnSpanFull(),
                ])->columns(2)->columnSpanFull(),
                Section::make('Project Attributes')
                    ->description('Add, remove, and reorder the facts displayed as bullets on the project page.')
                    ->schema([
                        Repeater::make('attributes_data')
                            ->label('Attributes')
                            ->schema([
                                TextInput::make('label')
                                    ->placeholder('e.g. Total Project Cost')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('value')
                                    ->placeholder('e.g. PKR 62,500 Million')
                                    ->required()
                                    ->maxLength(500),
                            ])
                            ->columns(2)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                            ->defaultItems(0)
                            ->addActionLabel('Add attribute')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Main Project Pictures')->description('Add one or more main pictures. Multiple pictures display as a slideshow; the first picture is used on project listings.')->schema([
                    Repeater::make('mainImages')->relationship()->schema([
                        FileUpload::make('path')->image()->imageResizeMode('contain')->imageResizeTargetWidth('1920')->imageResizeTargetHeight('1440')->disk('public')->directory('project-gallery')->maxSize(10240)->imagePreviewHeight('180')->required()->columnSpanFull(),
                        TextInput::make('caption'), TextInput::make('alt_text')->label('Alternative text'),
                        TextInput::make('sort_order')->numeric()->default(0), Hidden::make('is_featured')->default(true),
                    ])->columns(2)->reorderable('sort_order')->addActionLabel('Add main picture')->columnSpanFull(),
                ])->columnSpanFull(),
                Section::make('Project Gallery Pictures')->description('Optional additional pictures displayed in the Project Gallery at the end of the page.')->schema([
                    Repeater::make('galleryImages')->relationship()->schema([
                        FileUpload::make('path')->image()->imageResizeMode('contain')->imageResizeTargetWidth('1920')->imageResizeTargetHeight('1440')->disk('public')->directory('project-gallery')->maxSize(10240)->imagePreviewHeight('180')->required()->columnSpanFull(),
                        TextInput::make('caption'), TextInput::make('alt_text')->label('Alternative text'),
                        TextInput::make('sort_order')->numeric()->default(0), Hidden::make('is_featured')->default(false),
                    ])->columns(2)->reorderable('sort_order')->addActionLabel('Add gallery picture')->columnSpanFull(),
                ])->columnSpanFull(),
                Section::make('Publishing')->schema([
                    Select::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])->default('published')->required(),
                    DateTimePicker::make('published_at')->default(now()), TextInput::make('sort_order')->numeric()->default(0),
                ])->columns(3)->columnSpanFull(),
                Section::make('Search engine optimization')
                    ->description('Optional search and social-sharing settings. Project content is used by default.')
                    ->schema([
                        TextInput::make('meta.seo_title')->label('SEO title')->maxLength(60),
                        TextInput::make('meta.canonical_url')->label('Canonical URL')->url()->maxLength(500),
                        Textarea::make('meta.seo_description')->label('Meta description')->rows(3)->maxLength(160)->columnSpanFull(),
                        FileUpload::make('meta.social_image')->label('Social sharing image')->image()->disk('public')->directory('seo')->maxSize(5120),
                        Toggle::make('meta.noindex')->label('Hide from search engines'),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}

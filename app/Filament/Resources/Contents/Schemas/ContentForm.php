<?php

namespace App\Filament\Resources\Contents\Schemas;

use App\Models\ProjectCategory;
use Filament\Schemas\Schema;
use Filament\Forms\Components\{DateTimePicker, FileUpload, Hidden, RichEditor, Select, Textarea, TextInput};
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class ContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Content')->schema([
                    Select::make('type')->options(['page'=>'Page','post'=>'News','project'=>'Project','job'=>'Job','service'=>'Service','team'=>'Team'])->required()->default('page'),
                    TextInput::make('title')->required()->live(onBlur: true)->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')->required()->unique(ignoreRecord: true),
                    Select::make('category')->options(fn () => ProjectCategory::where('is_active', true)->orderBy('sort_order')->orderBy('name')->pluck('name', 'slug')->all())->visible(fn ($get) => $get('type') === 'project'),
                    Textarea::make('excerpt')->rows(3)->columnSpanFull(),
                    RichEditor::make('body')->columnSpanFull(),
                    Textarea::make('scope_of_project')->label('Scope of the Project')->rows(7)->visible(fn ($get) => $get('type') === 'project')->columnSpanFull(),
                    Textarea::make('scope_of_services')->label('Scope of Services')->rows(7)->visible(fn ($get) => $get('type') === 'project')->columnSpanFull(),
                    FileUpload::make('featured_image')->image()->directory('content')->columnSpanFull(),
                ])->columns(2)->columnSpanFull(),
                Section::make('Publishing')->schema([
                    Select::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])->required()->default('published'),
                    DateTimePicker::make('published_at')->default(now()),
                    TextInput::make('sort_order')->numeric()->default(0),
                    Hidden::make('wordpress_id'),
                ])->columns(3)->columnSpanFull(),
            ]);
    }
}

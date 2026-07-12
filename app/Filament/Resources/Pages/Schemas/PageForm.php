<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\{DateTimePicker, FileUpload, RichEditor, Select, Textarea, TextInput};
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->live(onBlur:true)->afterStateUpdated(fn($state,$set)=>$set('slug',Str::slug($state))), TextInput::make('slug')->required()->unique(ignoreRecord:true),
                Textarea::make('excerpt')->columnSpanFull(), RichEditor::make('body')->columnSpanFull(), FileUpload::make('featured_image')->image()->disk('public')->directory('pages')->maxSize(10240),
                Select::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])->default('published')->required(), DateTimePicker::make('published_at'), TextInput::make('sort_order')->numeric()->default(0),
            ]);
    }
}

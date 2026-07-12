<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\{FileUpload, Repeater, Textarea, TextInput, Toggle};
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->live(onBlur:true)->afterStateUpdated(fn($state,$set)=>$set('slug',Str::slug($state))), TextInput::make('slug')->required()->unique(ignoreRecord:true),
                FileUpload::make('image')->image()->disk('public')->directory('services')->maxSize(10240)->imagePreviewHeight('220')->helperText('JPG, PNG or WebP. Maximum size 10 MB.'), Textarea::make('description')->columnSpanFull(),
                Repeater::make('items')->simple(TextInput::make('item')->required())->columnSpanFull(), TextInput::make('sort_order')->numeric()->default(0), Toggle::make('is_active')->default(true),
            ]);
    }
}

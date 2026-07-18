<?php

namespace App\Filament\Resources\JobOpenings\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\{DatePicker, Textarea, TextInput, Toggle};
use Illuminate\Support\Str;

class JobOpeningForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->live(onBlur:true)->afterStateUpdated(fn($state,$set)=>$set('slug',Str::slug($state))), TextInput::make('slug')->required()->unique(ignoreRecord:true),
                TextInput::make('location'), DatePicker::make('closing_date'),
                Textarea::make('minimum_qualification')->label('Minimum Qualification')->rows(4)->required()->columnSpanFull(),
                Textarea::make('experience_required')->label('Experience Required')->rows(4)->required()->columnSpanFull(),
                TextInput::make('sort_order')->numeric()->default(0), Toggle::make('is_active')->default(true),
            ]);
    }
}

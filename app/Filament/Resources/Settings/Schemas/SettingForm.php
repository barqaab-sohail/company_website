<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\{Select, Textarea, TextInput};

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')->required()->unique(ignoreRecord: true),
                TextInput::make('label'),
                Select::make('group')->options(['general'=>'General','contact'=>'Contact','social'=>'Social','seo'=>'SEO'])->default('general')->required(),
                Textarea::make('value')->rows(6)->columnSpanFull(),
            ]);
    }
}
